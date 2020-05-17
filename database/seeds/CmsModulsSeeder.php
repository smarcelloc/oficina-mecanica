<?php

use Illuminate\Database\Seeder;

class CmsModulsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = $this->modulsLocal();


        foreach ($data as $k => $d) {
            if (DB::table('cms_moduls')->where('name', $d['name'])->count()) {
                unset($data[$k]);
            }
        }

        DB::table('cms_moduls')->insert($data);
    }



    private function modulsLocal()
    {
        return [

            [
                'created_at' => date('Y-m-d H:i:s'),
                'name' => 'Clientes',
                'icon' => 'fa fa-user',
                'path' => 'clients',
                'table_name' => 'clients',
                'controller' => 'AdminClientsController',
                'is_protected' => 0,
                'is_active' => 1,
            ],
            [
                'created_at' => date('Y-m-d H:i:s'),
                'name' => 'Fornecedores',
                'icon' => 'fa fa-truck',
                'path' => 'providers',
                'table_name' => 'providers',
                'controller' => 'AdminProvidersController',
                'is_protected' => 0,
                'is_active' => 1,
            ],
            [
                'created_at' => date('Y-m-d H:i:s'),
                'name' => 'Produtos',
                'icon' => 'fa fa-cubes',
                'path' => 'products',
                'table_name' => 'products',
                'controller' => 'AdminProductsController',
                'is_protected' => 0,
                'is_active' => 1,
            ],
            [
                'created_at' => date('Y-m-d H:i:s'),
                'name' => 'Veículos',
                'icon' => 'fa fa-car',
                'path' => 'vehicles',
                'table_name' => 'vehicles',
                'controller' => 'AdminVehiclesController',
                'is_protected' => 0,
                'is_active' => 1,
            ],
            [
                'created_at' => date('Y-m-d H:i:s'),
                'name' => 'Serviços',
                'icon' => 'fa fa-sliders',
                'path' => 'services',
                'table_name' => 'services',
                'controller' => 'AdminServicesController',
                'is_protected' => 0,
                'is_active' => 1,
            ],
            [
                'created_at' => date('Y-m-d H:i:s'),
                'name' => 'Pedidos',
                'icon' => 'fa fa-shopping-cart',
                'path' => 'orders',
                'table_name' => 'orders',
                'controller' => 'AdminOrdersController',
                'is_protected' => 0,
                'is_active' => 1,
            ],

            [

                'created_at' => date('Y-m-d H:i:s'),
                'name' => trans('crudbooster.Privileges'),
                'icon' => 'fa fa-cog',
                'path' => 'privileges',
                'table_name' => 'cms_privileges',
                'controller' => 'PrivilegesController',
                'is_protected' => 1,
                'is_active' => 1,
            ],
            [

                'created_at' => date('Y-m-d H:i:s'),
                'name' => trans('crudbooster.Privileges_Roles'),
                'icon' => 'fa fa-cog',
                'path' => 'privileges_roles',
                'table_name' => 'cms_privileges_roles',
                'controller' => 'PrivilegesRolesController',
                'is_protected' => 1,
                'is_active' => 1,
            ],
            [

                'created_at' => date('Y-m-d H:i:s'),
                'name' => trans('crudbooster.Users_Management'),
                'icon' => 'fa fa-users',
                'path' => 'users',
                'table_name' => 'cms_users',
                'controller' => 'AdminCmsUsersController',
                'is_protected' => 0,
                'is_active' => 1,
            ],
            [

                'created_at' => date('Y-m-d H:i:s'),
                'name' => trans('crudbooster.Menu_Management'),
                'icon' => 'fa fa-bars',
                'path' => 'menu_management',
                'table_name' => 'cms_menus',
                'controller' => 'MenusController',
                'is_protected' => 1,
                'is_active' => 1,
            ],
            [

                'created_at' => date('Y-m-d H:i:s'),
                'name' => trans('crudbooster.settings'),
                'icon' => 'fa fa-cog',
                'path' => 'settings',
                'table_name' => 'cms_settings',
                'controller' => 'SettingsController',
                'is_protected' => 1,
                'is_active' => 1,
            ],
            [

                'created_at' => date('Y-m-d H:i:s'),
                'name' => trans('crudbooster.Email_Templates'),
                'icon' => 'fa fa-envelope-o',
                'path' => 'email_templates',
                'table_name' => 'cms_email_templates',
                'controller' => 'EmailTemplatesController',
                'is_protected' => 1,
                'is_active' => 1,
            ]
        ];
    }
}
