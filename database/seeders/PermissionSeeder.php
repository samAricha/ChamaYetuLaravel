<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'view users',
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => 'create users',
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => 'edit users',
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => 'delete users',
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => 'add contribution',
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => 'create members',
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => 'create chamaas',
            'guard_name' => 'api',
        ]);
        Permission::create([
            'name' => 'create chamaa accounts',
            'guard_name' => 'api',
        ]);


    }
}
