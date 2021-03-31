<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Area;
use App\Models\User;
use App\Models\Empleado;
use App\Models\EmpleadoRol;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->create([
        //     'email' => 'a@admin.com',
        //     'password' => password_hash('123456',PASSWORD_DEFAULT)
        // ]);

        Area::factory(3)->create();
        Rol::factory(3)->create();        
        Empleado::factory(5)->create();
        EmpleadoRol::factory(3)->create();
    }
}
