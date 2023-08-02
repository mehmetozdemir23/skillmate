<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users with the password 'blabla'
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => bcrypt('blabla'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => bcrypt('blabla'),
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael.johnson@example.com',
                'password' => bcrypt('blabla'),
            ],
            [
                'name' => 'Emily Williams',
                'email' => 'emily.williams@example.com',
                'password' => bcrypt('blabla'),
            ],
        ];

        // Store users and get their IDs
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = DB::table('users')->insertGetId($user);
        }

        // Store skills
        $skills = [
            'PHP',
            'JavaScript',
            'Python',
            'Java',
        ];

        foreach ($skills as $skillName) {
            Skill::create(['name' => $skillName]);
        }

        // Associate 4 different skills to each user
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            $skills = Skill::inRandomOrder()->take(4)->get();
            $user->skills()->attach($skills);
        }

        // Create 3 different services for each skill of each user.
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            foreach ($user->skills as $skill) {
                $existingTitles = Service::where('user_id', '!=', $userId)->pluck('title')->toArray();
                $servicesData = [];
                for ($i = 1; $i <= 3; $i++) {
                    $title = $this->getServiceTitle($skill->name, $i, $existingTitles);
                    $description = $this->getServiceDescription($skill->name, $i);
                    $existingTitles[] = $title;
                    $servicesData[] = [
                        'user_id' => $user->id,
                        'skill_id' => $skill->id,
                        'title' => $title,
                        'description' => $description,
                    ];
                }
                Service::insert($servicesData);
            }
        }
    }

    private function getServiceTitle(string $skillName, int $index, array $existingTitles): string
    {
        $titles = [
            'Custom E-commerce Website Development',
            'Full-stack Web Application Development',
            'API Integration and Backend Development',
            'Mobile App Development',
        ];
        $title = $titles[$index - 1] . ' (' . $skillName . ')';
        $suffix = 2;
        while (in_array($title, $existingTitles)) {
            $title = $titles[$index - 1] . ' (' . $skillName . ' - ' . $suffix . ')';
            $suffix++;
        }
        return $title;
    }

    private function getServiceDescription(string $skillName, int $index): string
    {
        $descriptions = [
            'I will create a custom e-commerce website tailored to your business needs using the latest technologies.',
            'Get a fully functional and user-friendly web application that meets your specific requirements.',
            'Integrate APIs into your system and build a robust backend to support your application.',
            'Hire me to develop a mobile app for Android and iOS platforms.',
        ];
        return $descriptions[$index - 1];
    }
}
