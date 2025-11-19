<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTuongVyAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'tuongvy@gmail.com'],
            [
                'name' => 'Tuong Vy',
                'password' => Hash::make('tuongvy123'),
                'role' => 'admin',
            ]
        );

        $this->command->info('Tài khoản admin đã được tạo/cập nhật thành công!');
        $this->command->info('Email: tuongvy@gmail.com');
        $this->command->info('Password: tuongvy123');
        $this->command->info('Role: ' . $user->role);
    }
}
