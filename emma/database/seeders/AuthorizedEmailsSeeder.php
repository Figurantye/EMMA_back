<?php

namespace Database\Seeders;

use App\Models\AuthorizedEmail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorizedEmailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AuthorizedEmail::firstOrCreate([
            'email' => 'eva01.gustavo@gmail.com' // seu email principal
        ]);
    }
}
