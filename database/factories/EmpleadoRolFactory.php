<?php

namespace Database\Factories;

use App\Models\Rol;
use App\Models\Empleado;
use App\Models\EmpleadoRol;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoRolFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmpleadoRol::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'empleado_id' => Empleado::all()->random()->id,
            'rol_id' => Rol::all()->random()->id,
        ];
    }
}
