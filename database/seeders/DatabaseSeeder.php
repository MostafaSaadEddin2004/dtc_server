<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
        ]);

        $this->call([
            UserSeeder::class,
            CertificateTypeSeeder::class,
            SectionSeeder::class,
            DepartmentSeeder::class,
            DepartmentMarkSeeder::class,
            AcademicRegistrationSeeder::class,
            CourseSeeder::class,
            PostTypeSeeder::class,
            PostSeeder::class,
            LikeSeeder::class,
            SaveSeeder::class,
            NoteCategorySeeder::class,
            NoteSeeder::class,
            MoveSeeder::class,
            EditMarkSeeder::class,
            TeacherRegistrationSeeder::class,
        ]);
    }
}
