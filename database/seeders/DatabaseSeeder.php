<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'BK', 'slug' => 'bk', 'description' => 'Bimbingan Konseling'],
            ['name' => 'Sarpras', 'slug' => 'sarpras', 'description' => 'Sarana Prasarana'],
            ['name' => 'Kurikulum', 'slug' => 'kurikulum', 'description' => 'Kurikulum'],
            ['name' => 'Kesiswaan', 'slug' => 'kesiswaan', 'description' => 'Kesiswaan'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@sekolah.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
        ]);

        // Create Admins for each category
        $admins = [
            ['name' => 'Admin BK', 'email' => 'bk@sekolah.com', 'category' => 'BK'],
            ['name' => 'Admin Sarpras', 'email' => 'sarpras@sekolah.com', 'category' => 'Sarpras'],
            ['name' => 'Admin Kurikulum', 'email' => 'kurikulum@sekolah.com', 'category' => 'Kurikulum'],
            ['name' => 'Admin Kesiswaan', 'email' => 'kesiswaan@sekolah.com', 'category' => 'Kesiswaan'],
        ];

        foreach ($admins as $admin) {
            $category = Category::where('name', $admin['category'])->first();
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make('password'),
                'role' => 'admin',
                'category_id' => $category->id,
            ]);
        }
    }
}
