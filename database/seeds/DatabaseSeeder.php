<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CmsModulsSeeder::class);
        $this->call(CmsMenusSeeder::class);
        $this->call(CmsSettingsSeeder::class);
        $this->call(CmsPrivilegesSeeder::class);
        $this->call(CmsPrivilegesRolesSeeder::class);
        $this->call(CmsUsersSeeder::class);
        $this->call(CmsServicesSeeder::class);
        $this->call(CmsEmailTemplateSeeder::class);
    }
}

