<?php
namespace Tests\Feature;

use App\Models\Service;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private User $user;
    private Service $userService;
    private Skill $skill;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->skill = $this->createSkill();
        $this->userService = $this->createService($this->user, $this->skill);
    }

    public function test_user_can_see_service_board(): void
    {
        $response = $this->actingAs($this->user)->get('/service-board');

        $response->assertOk();
    }

    public function test_user_cannot_see_own_services_in_service_board(): void
    {
        $response = $this->actingAs($this->user)->get('/service-board');

        $response->assertOk()
            ->assertViewHas('services', function ($services) {
                return $services->every(fn($service) => $service->user_id != $this->user->id);
            });
    }

    public function test_user_can_see_his_own_services(): void
    {
        $response = $this->actingAs($this->user)->get('/services');

        $response->assertOk()
            ->assertViewHas('services', $this->user->services);
    }

    public function test_user_can_access_create_service_form(): void
    {
        $response = $this->actingAs($this->user)->get('/services/create');

        $response->assertOk()->assertSee('New service');
    }

    public function test_user_can_create_service(): void
    {
        $serviceData = [
            'title' => 'service title',
            'description' => 'service description',
            'skill_id' => $this->skill->id,
        ];

        $response = $this->actingAs($this->user)->post('/services', $serviceData);

        $this->assertDatabaseHas('services', $serviceData);
        $response->assertRedirect('/services')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    public function test_user_can_delete_service(): void
    {        
        $response = $this->actingAs($this->user)->delete('/services/' . $this->userService->id);

        $this->assertDatabaseMissing('services', $this->userService->toArray());
        $response->assertRedirect('/services')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    private function createUser(): User
    {
        return User::factory()->create();
    }

    private function createService($user, $skill): Service
    {
        return Service::factory()->create([
            'user_id' => $user->id,
            'skill_id' => $skill->id
        ]);
    }

    private function createSkill(): Skill
    {
        return Skill::factory()->create();
    }
}