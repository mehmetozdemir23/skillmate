<?php

namespace Tests\Feature;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
    }

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {

        $response = $this
            ->actingAs($this->user)
            ->patch('/profile/info', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->user->refresh();

        $this->assertSame('Test User', $this->user->name);
        $this->assertSame('test@example.com', $this->user->email);
        $this->assertNull($this->user->email_verified_at);
    }

    public function test_user_password_can_be_updated(): void
    {
        $user = User::create([
            'name' => 'john',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)->patch('/profile/password', [
            'current_password' => 'password',
            'new_password' => 'blablabla',
            'new_password_confirmation' => 'blablabla'
        ]);

        $response->assertSessionHasNoErrors()
            ->assertSessionHas('success')
            ->assertRedirect('/profile');
    }

    public function test_not_confirmed_password_cannot_be_updated(): void
    {
        $user = User::create([
            'name' => 'john',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)->patch('/profile/password', [
            'current_password' => 'password',
            'new_password' => 'blablabla',
            'new_password_confirmation' => 'blobloblo'
        ]);

        $response->assertSessionHas('errors')
            ->assertRedirect('/profile');

    }
/*
    public function test_user_can_update_avatar(): void
    {
        $avatarImage = UploadedFile::fake()->create('avatar.jpg');
        $hashName = $avatarImage->hashName();
        $lastAvatar = $this->user->avatar != 'default-avatar.svg' ? $this->user->avatar : null;

        $response = $this->actingAs($this->user)->patch('/profile/avatar', ['avatar' => $avatarImage]);

        $response->assertSessionHas('success')->assertRedirect('/profile');

        $this->user->refresh();
        $this->assertEquals($hashName, $this->user->avatar);

        if ($lastAvatar) {
            $this->assertFileDoesNotExist(storage_path('app/public/avatars/' . $lastAvatar));
        }

    }

    public function test_user_can_delete_avatar(): void
    {
        $response = $this->actingAs($this->user)->delete('profile/avatar');
        $response->assertSessionHas('success')
            ->assertRedirect('/profile');

        $this->user->refresh();
        $this->assertEquals('default-avatar.svg', $this->user->avatar);
    }
*/
    public function test_add_skill_button_redirects_to_add_skill_form(): void
    {
        $response = $this->actingAs($this->user)->get('/profile/skills/add');

        $response->assertSee('New Skill');
    }

    public function test_user_can_add_skill(): void
    {
        $skill = Skill::factory()->create();

        $response = $this->actingAs($this->user)->post('/profile/skills', ['skill_id' => $skill->id]);

        $response->assertSessionHas('success')
            ->assertRedirect('/profile');

    }

    public function test_user_can_delete_skill(): void
    {
        $skill = Skill::factory()->create();
        $this->user->skills()->attach($skill);

        $response = $this->actingAs($this->user)->delete('/profile/skills/' . $skill->id);

        $response->assertSessionHasNoErrors()
            ->assertSessionHas('success')
            ->assertRedirect('/profile');
    }

    public function test_user_can_delete_their_account(): void
    {

        $response = $this
            ->actingAs($this->user)
            ->delete('/profile/account', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/login');

        $this->assertGuest();
        $this->assertNull($this->user->fresh());
    }

    private function createUser(): User
    {
        return User::factory()->create();
    }

    /*
            public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
            {
                $user = User::factory()->create();

                $response = $this
                    ->actingAs($user)
                    ->patch('/profile', [
                        'name' => 'Test User',
                        'email' => $user->email,
                    ]);

                $response
                    ->assertSessionHasNoErrors()
                    ->assertRedirect('/profile');

                $this->assertNotNull($user->refresh()->email_verified_at);
            }

            

            public function test_correct_password_must_be_provided_to_delete_account(): void
            {
                $user = User::factory()->create();

                $response = $this
                    ->actingAs($user)
                    ->from('/profile')
                    ->delete('/profile', [
                        'password' => 'wrong-password',
                    ]);

                $response
                    ->assertSessionHasErrorsIn('userDeletion', 'password')
                    ->assertRedirect('/profile');

                $this->assertNotNull($user->fresh());
            }*/
}