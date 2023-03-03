<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        <?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('roles')->insert([
            ['id' => 1, 'name' => "Admin"],
            ['id' => 2, 'name' => "Product Owner"],
            ['id' => 3, 'name' => "Team Member"]
        ]);

        DB::table('modules')->insert([
            ['id' => 1, 'name' => "User Module"],
            ['id' => 2, 'name' => "Project Module"],
            ['id' => 3, 'name' => "Create Task"],
            ['id' => 4, 'name' => "View Task"],
            ['id' => 5, 'name' => "Update Task"]
        ]);

        DB::table('task_statuses')->insert([
            ['id' => 1, 'name' => "NOT_STARTED"],
            ['id' => 2, 'name' => "IN_PROGRESS"],
            ['id' => 3, 'name' => "READY_FOR_TEST"],
            ['id' => 4, 'name' => "COMPLETED"]
        ]);

        DB::table('role_permissions')->insert([
            ['id' => 1, 'role_id' => 1, 'module_id' => 1],
            ['id' => 2, 'role_id' => 2, 'module_id' => 2],
            ['id' => 3, 'role_id' => 2, 'module_id' => 3],
            ['id' => 4, 'role_id' => 2, 'module_id' => 4],
            ['id' => 5, 'role_id' => 2, 'module_id' => 5],
            ['id' => 6, 'role_id' => 3, 'module_id' => 5],
            ['id' => 6, 'role_id' => 3, 'module_id' => 4],
        ]);
    }
}

    }
}
