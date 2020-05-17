<?php

use Illuminate\Database\Seeder;

class CmsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('cms_users')->count() == 0) {
            DB::table('cms_users')->insert([
                'created_at' => date('Y-m-d H:i:s'),
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin@123'),
                'id_cms_privileges' => 1,
                'status' => 'Active',
            ]);
        }
    }
}
