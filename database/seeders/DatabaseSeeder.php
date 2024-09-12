<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\PostFactory;
use Database\Factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // $this->call('UsersTableSeeder');
        $roles = RoleFactory::new()->count(5)->create();
        UserFactory::new()
            ->count(5)
            ->has(PostFactory::new()->count(5))
            ->create()
            ->each(function (User $user) use($roles) {
                $user->roles()->attach($roles->random(2));
            });

    }
}
