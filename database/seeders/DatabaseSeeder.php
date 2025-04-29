<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        User::create([
            'name' => 'guru',
            'username' => 'guru',
            'role' => 'tasker',
            'password' => bcrypt('guru123'),
        ]);

        User::create([
            'name' => 'siswa',
            'username' => 'siswa',
            'role' => 'worker',
            'password' => bcrypt('siswa123'),
        ]);
    }
}
