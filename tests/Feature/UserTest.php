<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;
    public function test_specific_user_profile_is_displayed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $response = $this->get(route('users.show', $otherUser));

        $response->assertOk()->assertSee($otherUser->name);
    }

    public function test_auth_user_is_redirected_to_own_profile():void{
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/users/'.$user->id);

        $response->assertRedirect('/profile');
    }
}