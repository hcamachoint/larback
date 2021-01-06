<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
      DB::table('users')->insert([
        'name' => 'Administrador',
        'email' => 'admin@local.dev',
        'email_verified_at' => '2020-11-18 21:26:27',
        'password' => '$2y$10$alHgrroTLWWx0XhQrWcUYuL.3Gj2AlLhrKs7uW8XtHpscjlC0GXuy', //Password es: asd123..
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
      ]);
    }
}
