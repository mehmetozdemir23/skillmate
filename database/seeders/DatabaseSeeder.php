<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create users
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create skills
        $skill1 = Skill::create([
            'name' => 'Web Development',
        ]);

        $skill2 = Skill::create([
            'name' => 'Database Management',
        ]);

        // Create services offered
        $service1 = Service::create([
            'user_id' => $user1->id,
            'skill_id' => $skill1->id,
            'title' => 'Custom Website Development',
            'description' => 'I will build a custom website for your business using the latest technologies.',
        ]);

        $service2 = Service::create([
            'user_id' => $user2->id,
            'skill_id' => $skill2->id,
            'title' => 'Database Optimization',
            'description' => 'I will optimize your database queries for better performance.',
        ]);

        // Create service requests
        $serviceRequest1 = ServiceRequest::create([
            'user_id' => $user2->id,
            'service_id' => $service1->id,
            'notes' => 'I need a custom website for my small business.',
        ]);

        $serviceRequest2 = ServiceRequest::create([
            'user_id' => $user1->id,
            'service_id' => $service2->id,
            'notes' => 'I need help optimizing my database queries.',
        ]);

        // Create reviews
        $review1 = Review::create([
            'service_id' => $service1->id,
            'reviewer_id' => $user2->id,
            'reviewee_id' => $user1->id,
            'comment' => 'John did an excellent job building my website. Highly recommended!',
            'rating' => 5,
            'type' => 'received',
        ]);

        $review2 = Review::create([
            'service_id' => $service2->id,
            'reviewer_id' => $user1->id,
            'reviewee_id' => $user2->id,
            'comment' => 'Jane helped me optimize my database queries, and the performance improvements were amazing!',
            'rating' => 4,
            'type' => 'received',
        ]);

        $review3 = Review::create([
            'service_id' => $service1->id,
            'reviewer_id' => $user1->id,
            'reviewee_id' => $user2->id,
            'comment' => 'Jane requested my web development service and was a pleasure to work with.',
            'rating' => 4,
            'type' => 'left',
        ]);

        $review4 = Review::create([
            'service_id' => $service2->id,
            'reviewer_id' => $user2->id,
            'reviewee_id' => $user1->id,
            'comment' => 'John provided valuable insights into database optimization.',
            'rating' => 5,
            'type' => 'left',
        ]);
    }
}
