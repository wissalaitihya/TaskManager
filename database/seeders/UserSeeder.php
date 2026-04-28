<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Facade\Sequence;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@taskmanager.com',
            'password' => Hash::make('password'),
        ]);

        $tasks = [
            [
                'category_id' => 1,
                'title' => 'Finish Laravel project',
                'description' => 'Complete all user stories',
                'status' => 'to_do',
                'due_date' => '2026-04-29',
            ],
            [
                'category_id' => 2,
                'title' => 'Buy groceries',
                'description' => 'Milk, Bread, Eggs',
                'status' => 'in_progress',
                'due_date' => '2026-04-28',
            ],
            [
                'category_id' => 3,
                'title' => 'Go to the gym',
                'description' => 'Leg day workout',
                'status' => 'done',
                'due_date' => '2026-04-27',
            ],
        ];
        foreach ($tasks as $task) {
            $user->tasks()->create($task);
        }
    }
}
