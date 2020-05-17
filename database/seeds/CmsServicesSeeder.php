<?php

use Illuminate\Database\Seeder;

class CmsServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('services')->count() == 0){
            DB::table('services')->insert(['name' => 'Reparos Automóveis', 'created_at' => now()]);
            DB::table('services')->insert(['name' => 'Troca de Óleo', 'created_at' => now()]);
            DB::table('services')->insert(['name' => 'Revenda de Produtos', 'created_at' => now()]);
            DB::table('services')->insert(['name' => 'Reparos Automoveis', 'created_at' => now()]);
            DB::table('services')->insert(['name' => 'Alinhamento e Balaceamento', 'created_at' => now()]);
            DB::table('services')->insert(['name' => 'Freios', 'created_at' => now()]);
            DB::table('services')->insert(['name' => 'Suspensão', 'created_at' => now()]);
            DB::table('services')->insert(['name' => 'Injeção Eletrônica', 'created_at' => now()]);
            DB::table('services')->insert(['name' => 'Sistema Elétrico', 'created_at' => now()]);
        }
    }
}
