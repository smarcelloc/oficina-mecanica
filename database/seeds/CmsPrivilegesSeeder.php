<?php

use Illuminate\Database\Seeder;

class CmsPrivilegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (DB::table('cms_privileges')->where('name', 'Super Administrator')->count() == 0) {
            DB::table('cms_privileges')->insert([
                'created_at' => date('Y-m-d H:i:s'),
                'name' => 'Super Administrator',
                'is_superadmin' => 1,
            ]);
        }
    }
}
