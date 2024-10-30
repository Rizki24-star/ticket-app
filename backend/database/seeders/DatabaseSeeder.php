<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678')
        ]);

        User::factory()->create([
            'name' => 'client 1',
            'role' => 'client',
            'email' => 'client1@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        User::factory()->create([
            'name' => 'client 2',
            'role' => 'client',
            'email' => 'client2@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        DB::table('tickets')->insert([
            'client_id' => 2,
            'title' => 'Judul Ticket 1',
            'description' => 'Ticket Description',
            'status' => 'open',
            'admin_response' => 'reponse'
        ]);

        DB::table('tickets')->insert([
            'client_id' => 2,
            'title' => 'Judul Ticket 2',
            'description' => 'Ticket Description',
            'status' => 'open',
            'admin_response' => 'reponse'
        ]);

        DB::table('tickets')->insert([
            'client_id' => 3,
            'title' => 'Judul Ticket 3',
            'description' => 'Ticket Description',
            'status' => 'open',
            'admin_response' => 'reponse'
        ]);

        DB::table('tickets')->insert([
            'client_id' => 3,
            'title' => 'Judul Ticket 4',
            'description' => 'Ticket Description',
            'status' => 'open',
            'admin_response' => 'reponse'
        ]);
    }
}
