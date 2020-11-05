<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'director' => $this->faker->name,
            'director_type' => $this->randomDirector_type(),
            'budget' => $this->faker->numberBetween($min = 10000, $max = 100000),
        ];
    }

    private function randomDirector_type() {
        $types = array(
            'En propiedad',
            'En funciones',
        );
        return $types[rand ( 0 , count($types) -1)];
    }
}
