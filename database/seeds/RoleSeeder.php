<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::updateOrCreate([
                'name'  =>  'Admin',
                'name_api'  =>  'admin',
        ]);
        \App\Role::updateOrCreate([
            'name'  =>  'Gerente',
            'name_api'  =>  'gerente',
        ]);
    }
}
