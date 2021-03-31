<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Empleado::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'sexo' => rand(0,1) == 1 ? 'M' : 'F',
            'area_id' => Area::all()->random()->id,
            'boletin' => rand(0,1),
            'descripcion' => $this->faker->text(100),
        ];
    }
}
