<?php

use Illuminate\Database\Seeder;

class CmsMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->menu();
        $id = 0;

        foreach ($data as $k => $d) {
            if (DB::table('cms_menus')->where('name', $d['name'])->count()) {
                unset($data[$k]);
            }

            DB::table('cms_menus_privileges')->insert([
                'id_cms_menus' => ++$id,
                'id_cms_privileges' => 1
            ]);
        }

        DB::table('cms_menus')->insert($data);
    }

    private function menu()
    {
        return [
            [
                'name' => 'Clientes',
                'type' => 'Route',
                'path' => 'AdminClientsControllerGetIndex',
                'color' => 'normal',
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'is_active' => 1,
                'sorting' => 1,
                'id_cms_privileges' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Veículos',
                'type' => 'Route',
                'path' => 'AdminVehiclesControllerGetIndex',
                'color' => 'normal',
                'icon' => 'fa fa-car',
                'parent_id' => 0,
                'is_active' => 1,
                'sorting' => 2,
                'id_cms_privileges' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fornecedores',
                'type' => 'Route',
                'path' => 'AdminProvidersControllerGetIndex',
                'color' => 'normal',
                'icon' => 'fa fa-truck',
                'parent_id' => 0,
                'is_active' => 1,
                'sorting' => 3,
                'id_cms_privileges' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Produtos',
                'type' => 'Route',
                'path' => 'AdminProductsControllerGetIndex',
                'color' => 'normal',
                'icon' => 'fa fa-cubes',
                'parent_id' => 0,
                'is_active' => 1,
                'sorting' => 4,
                'id_cms_privileges' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Serviços',
                'type' => 'Route',
                'path' => 'AdminServicesControllerGetIndex',
                'color' => 'normal',
                'icon' => 'fa fa-sliders',
                'parent_id' => 0,
                'is_active' => 1,
                'sorting' => 5,
                'id_cms_privileges' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Pedidos',
                'type' => 'Route',
                'path' => 'AdminOrdersControllerGetIndex',
                'color' => 'normal',
                'icon' => 'fa fa-shopping-cart',
                'parent_id' => 0,
                'is_active' => 1,
                'sorting' => 6,
                'id_cms_privileges' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
    }
}
