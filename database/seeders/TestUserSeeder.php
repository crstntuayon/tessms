<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'System Admin')->first();
        $registrarRole = Role::where('name', 'Registrar')->first();
        $teacherRole = Role::where('name', 'Teacher')->first();
        $studentRole = Role::where('name', 'Student')->first();

        // Admin
        User::firstOrCreate([
            'email' => 'admin@tugaweES.edu.ph'
        ], [
            'name' => 'System Admin',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);

        // Registrar
        User::firstOrCreate([
            'email' => 'registrar@tugaweES.edu.ph'
        ], [
            'name' => 'Registrar User',
            'password' => Hash::make('password'),
            'role_id' => $registrarRole->id
        ]);

        // Teacher
        $teacher = User::firstOrCreate([
            'email' => 'teacher@tugaweES.edu.ph'
        ], [
            'name' => 'Teacher One',
            'password' => Hash::make('password'),
            'role_id' => $teacherRole->id
        ]);

        // Student
        $studentUser = User::firstOrCreate([
            'email' => 'student@tugaweES.edu.ph'
        ], [
            'name' => 'Juan Dela Cruz',
            'password' => Hash::make('password'),
            'role_id' => $studentRole->id
        ]);

        Student::firstOrCreate([
            'user_id' => $studentUser->id
        ], [
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'section_id' => 1 // make sure section ID exists
        ]);
    }
}
