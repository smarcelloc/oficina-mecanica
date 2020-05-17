<?php

use Illuminate\Database\Seeder;

class CmsPrivilegesRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (DB::table('cms_privileges_roles')->count() == 0) {
            $modules = DB::table('cms_moduls')->get();
            $i = 1;
            foreach ($modules as $module) {

                $is_visible = 1;
                $is_create = 1;
                $is_read = 1;
                $is_edit = 1;
                $is_delete = 1;

                switch ($module->table_name) {
                    case 'cms_logs':
                        $is_create = 0;
                        $is_edit = 0;
                        $is_delete = 0;
                        break;
                    case 'cms_privileges_roles':
                        $is_visible = 0;
                        break;
                }

                DB::table('cms_privileges_roles')->insert([
                    'created_at' => date('Y-m-d H:i:s'),
                    'is_visible' => $is_visible,
                    'is_create' => $is_create,
                    'is_edit' => $is_edit,
                    'is_delete' => $is_delete,
                    'is_read' => $is_read,
                    'id_cms_privileges' => 1,
                    'id_cms_moduls' => $module->id,
                ]);
                $i++;
            }
        }
    }
}
