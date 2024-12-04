<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Player']);
        Role::create(['name' => 'Raffler']);
        Role::create(['name' => 'Admin']);
    }
}
