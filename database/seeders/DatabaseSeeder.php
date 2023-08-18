<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Mission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Creating a test user
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Creating other users
        $user2 = User::create([
            'name' => 'User2',
            'email' => 'user2@example.com',
            'password' => Hash::make('user2password'),
        ]);

        $user3 = User::create([
            'name' => 'User3',
            'email' => 'user3@example.com',
            'password' => Hash::make('user3password'),
        ]);

        // Creating technical skills
        $skills = [
            ['name' => 'Web Development'],
            ['name' => 'Mobile App Development'],
            ['name' => 'UI/UX Design'],
        ];
        Skill::insert($skills);

        // Creating services for the test user
        $testUserServices = [];
        $serviceTitles = [
            'Custom Website Development',
            'Mobile App Design and Development',
            'User-Centric UI/UX Solutions',
            'E-Commerce Website Creation',
            'Responsive Web Design Services',
        ];
        
        foreach ($serviceTitles as $index => $title) {
            $serviceType = $skills[$index % 3]['name'];
            $description = "Expert $serviceType services tailored to your unique requirements. Enhance your online presence with effective solutions.";
            $testUserServices[] = [
                'user_id' => $testUser->id,
                'skill_id' => rand(1, 3),
                'title' => $title,
                'description' => $description,
            ];
        }
        Service::insert($testUserServices);

        // Creating services for other users
        $user2Services = [
            [
                'user_id' => $user2->id,
                'skill_id' => rand(1, 3),
                'title' => 'Mobile App Development',
                'description' => 'Specializing in creating innovative mobile applications to meet your business goals.',
            ],
            [
                'user_id' => $user2->id,
                'skill_id' => rand(1, 3),
                'title' => 'Web Design Services',
                'description' => 'Crafting visually appealing and user-friendly web designs for a seamless online experience.',
            ],
        ];
        Service::insert($user2Services);

        $user3Services = [
            [
                'user_id' => $user3->id,
                'skill_id' => rand(1, 3),
                'title' => 'UI/UX Consulting',
                'description' => 'Providing expert advice and guidance to enhance the user experience and interface of your applications.',
            ],
        ];
        Service::insert($user3Services);

    }
}
