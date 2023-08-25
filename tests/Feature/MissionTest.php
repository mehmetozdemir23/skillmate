<?php

namespace Tests\Feature;

use App\Models\Mission;
use App\Models\Service;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MissionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Skill $skill;
    private Service $service;
    private Collection $proposedMissions;
    private Collection $receivedMissions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->skill = $this->createSkill();
        $this->user->skills()->save($this->skill);
        $this->service = $this->createService($this->user, $this->skill);

        // create missions done by the user
        $receivers = User::factory(2)->create();
        $this->proposedMissions = new Collection;
        foreach ($receivers as $receiver) {
            $this->proposedMissions->add($this->createMission($receiver, $this->service));
        }

        // create 2 missions that the user is the beneficiary of.
        $serviceProvidingUser = $this->createUser();
        $serviceProvidingUserSkill = $this->createSkill();
        $serviceProvided = $this->createService($serviceProvidingUser, $serviceProvidingUserSkill);
        $this->receivedMissions = new Collection;
        $this->receivedMissions->add(
            $this->createMission($this->user, $serviceProvided)
        );
        $this->receivedMissions->add(
            $this->createMission($this->user, $serviceProvided)
        );

    }

    public function test_user_can_see_all_his_missions(): void
    {
        $response = $this->actingAs($this->user)->get('/missions');

        $response->assertOk()
            ->assertViewHas('missions', $this->proposedMissions);
    }

    public function test_user_can_see_proposed_missions(): void
    {
        $response = $this->actingAs($this->user)->get('/missions?filter-by-type=proposed');

        $response->assertOk()
            ->assertViewHas('missions', $this->proposedMissions);
    }

    public function test_user_can_see_received_missions(): void
    {
        $response = $this->actingAs($this->user)->get('/missions?filter-by-type=received');

        $response->assertOk()
            ->assertViewHas('missions', $this->receivedMissions);
    }

    public function test_user_can_start_mission(): void
    {
        $receiver = User::factory()->create();
        $mission = $this->createMission($receiver, $this->service);

        $response = $this->actingAs($this->user)->post('/missions/' . $mission->id . '/start');
        $mission->refresh();

        $this->assertEquals('in_progress', $mission->status);
        $response->assertRedirect('/missions');
    }

    public function test_user_can_end_mission(): void
    {
        $receiver = User::factory()->create();
        $mission = $this->createMission($receiver, $this->service);

        $response = $this->actingAs($this->user)->post('/missions/' . $mission->id . '/end');
        $mission->refresh();

        $this->assertEquals('completed', $mission->status);
        $response->assertRedirect('/missions');

    }

    public function test_user_can_access_create_review_form(): void
    {

        //pick a received mission to be reviewed, the last one for example.
        $mission = $this->user->missions->last();

        $response = $this->actingAs($this->user)->get('/missions/' . $mission->id . '/review/create');

        $response->assertOk()->assertViewHas('mission', $mission);
    }

    public function test_user_can_review_a_completed_mission(): void
    {
        $mission = $this->user->missions->last();
        $mission->status = 'completed';
        $mission->save();
        $mission->refresh();
        $missionReviewComment = 'comment for mission ' . $mission->id;

        $response = $this->actingAs($this->user)
            ->post('/missions/' . $mission->id . '/review', [
                'rating' => 5,
                'comment' => $missionReviewComment
            ]);

        $this->assertTrue(
            $mission->review->reviewer_id == $this->user->id
            && $mission->review->mission_id == $mission->id
            && $mission->review->rating == 5
            && $mission->review->comment == $missionReviewComment
        );
        $response->assertRedirect('/missions');
    }

    public function test_user_cannot_review_an_uncompleted_mission(): void
    {
        $mission = $this->user->missions->last();
        $mission->status = 'pending';

        $response = $this->actingAs($this->user)
            ->post('/missions/' . $mission->id . '/review', [
                'rating' => 5,
                'comment' => 'comment for mission ' . $mission->id
            ]);

        $this->assertDatabaseMissing('reviews', [
            'mission_id' => $mission->id,
            'reviewer_id' => $this->user->id,
        ]);
        $response->assertRedirect('/missions');
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

    private function createMission($receiver, $service): Mission
    {
        return Mission::factory()->create([
            'receiver_id' => $receiver->id,
            'service_id' => $service->id,
        ]);
    }
}