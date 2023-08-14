<?php

namespace Database\Seeders;

use App\Models\Mission;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        // Bind skills to users
        $skill_user1 = DB::table('skill_user')->insert([
            'user_id'=>$user1->id,
            'skill_id'=>$skill1->id
        ]);

        $skill_user2 = DB::table('skill_user')->insert([
            'user_id'=>$user2->id,
            'skill_id'=>$skill2->id
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
            'sender_id' => $user2->id,
            'service_id' => $service1->id,
            'notes' => 'I need a custom website for my small business.',
        ]);

        $serviceRequest2 = ServiceRequest::create([
            'sender_id' => $user1->id,
            'service_id' => $service2->id,
            'notes' => 'I need help optimizing my database queries.',
        ]);

        

       
    }
}
