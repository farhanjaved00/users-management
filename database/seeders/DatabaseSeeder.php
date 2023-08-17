<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = ['admin@gmail.com','manager@gmail.com','dummy_user@gmail.com'];
        foreach($users as $user) {
            if(! User::where('email',$user)->first()){
                User::factory()->create([
                    'name' => explode('@',$user)[0],
                    'email' => $user,
                    'password' => Hash::make('12345678')
                ]);
            }

        }

        $this->call(RolesAndPermissionsSeeder::class);
    }
}
