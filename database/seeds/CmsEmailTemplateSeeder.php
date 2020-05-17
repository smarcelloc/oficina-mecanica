<?php

use Illuminate\Database\Seeder;

class CmsEmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cms_email_templates')->insert([
                'created_at' => date('Y-m-d H:i:s'),
                'name' => 'Modelo de e-mail Esqueceu a senha?',
                'slug' => 'forgot_password_backend',
                'content' => '<p>Olá,</p><p>Alguém solicitado esqueceu a senha, aqui está sua nova senha : </p><p>[password]</p><p><br></p><p>--</p><p>Saudação,</p><p>Admin</p>',
                'description' => '[password]',
                'from_name' => 'System',
                'from_email' => 'system@oficina.com',
                'cc_email' => null,
            ]);
    }
}
