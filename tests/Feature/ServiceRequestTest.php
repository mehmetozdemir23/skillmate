<?php

namespace Tests\Feature;

use App\Models\ServiceRequest;
use App\Models\Service;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceRequestTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Skill $skill;
    private Service $service;
    private ServiceRequest $receivedServiceRequest;
    private ServiceRequest $sentServiceRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->skill = $this->createSkill();
        $this->service = $this->createService($this->user, $this->skill);

        // Create a received service request for the user
        $sender = $this->createUser();
        $this->receivedServiceRequest = $this->createServiceRequest($sender, $this->user, $this->service);

        // Create a sent service request by the user
        $receiver = $this->createUser();
        $this->sentServiceRequest = $this->createServiceRequest($this->user, $receiver, $this->service);
    }

    public function test_user_can_see_received_service_requests(): void
    {
        $response = $this->actingAs($this->user)->get('/service-requests/received');

        $response->assertOk()
            ->assertViewHas('receivedServiceRequests', function ($receivedServiceRequests) {
                return $receivedServiceRequests->contains($this->receivedServiceRequest);
            });
    }

    public function test_user_can_see_sent_service_requests(): void
    {
        $response = $this->actingAs($this->user)->get('/service-requests/sent');

        $response->assertOk()
            ->assertViewHas('sentServiceRequests', function ($sentServiceRequests) {
                return $sentServiceRequests->contains($this->sentServiceRequest);
            });
    }

    public function test_user_can_create_service_request(): void
    {
        $receiver = $this->createUser();
        $serviceData = [
            'title' => 'service title',
            'description' => 'service description',
            'skill_id' => $this->skill->id,
            'user_id' => $receiver->id,
        ];
        $service = Service::factory()->create($serviceData);

        $response = $this->actingAs($this->user)
            ->post('/services/' . $service->id . '/requests', [
                'sender_id' => $this->user->id,
                'service_id' => $service->id,
                'notes' => 'test notes'
            ]);

        $this->assertDatabaseHas('service_requests', [
            'sender_id' => $this->user->id,
            'service_id' => $service->id,
            'notes' => 'test notes'
        ]);

        $response->assertRedirect('/service-requests/sent');
    }

    public function test_user_can_accept_service_request(): void
    {
        $response = $this->actingAs($this->user)
            ->post('/services/' . $this->service->id . '/requests/' . $this->receivedServiceRequest->id . '/accept');

        $this->assertEquals('accepted', $this->receivedServiceRequest->fresh()->status);
        $this->assertDatabaseHas('missions', [
            'service_id' => $this->service->id,
            'receiver_id' => $this->receivedServiceRequest->sender->id
        ]);

        $response->assertRedirect('/service-requests/received');
    }

    public function test_user_can_decline_service_request(): void
    {
        $response = $this->actingAs($this->user)
            ->post('/services/' . $this->service->id . '/requests/' . $this->receivedServiceRequest->id . '/decline');

        $this->assertEquals('declined', $this->receivedServiceRequest->fresh()->status);

        $response->assertRedirect('/service-requests/received');
    }

    public function test_user_can_undo_service_request_status_change(): void
    {
        $this->receivedServiceRequest->status = 'accepted';
        $this->receivedServiceRequest->save();

        $response = $this->actingAs($this->user)
            ->post('/services/' . $this->service->id . '/requests/' . $this->receivedServiceRequest->id . '/undo');

        $this->assertEquals('pending', $this->receivedServiceRequest->fresh()->status);

        $response->assertRedirect('/service-requests/received');
    }

    public function test_user_can_delete_service_request(): void
    {
        $response = $this->actingAs($this->user)
            ->delete('/services/' . $this->service->id . '/requests/' . $this->receivedServiceRequest->id);

        $this->assertDatabaseMissing('service_requests', $this->receivedServiceRequest->toArray());

        $response->assertRedirect('/service-requests/received');
    }
    private function createUser(): User
    {
        return User::factory()->create();
    }

    private function createSkill(): Skill
    {
        return Skill::factory()->create();
    }

    private function createService($user, $skill): Service
    {
        return Service::factory()->create([
            'user_id' => $user->id,
            'skill_id' => $skill->id
        ]);
    }

    private function createServiceRequest($sender, $receiver, $service): ServiceRequest
    {
        return ServiceRequest::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'service_id' => $service->id
        ]);
    }
}