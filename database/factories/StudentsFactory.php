<?php

namespace Database\Factories;

use App\Models\Students;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentsFactory extends Factory
{
    protected $model = Students::class;

    public function definition()
    {
        $mobileNumber = '09' . $this->faker->randomNumber(9);

        return [
            'id_no' => $this->faker->unique()->numberBetween(20210000, 20219999),
            'fname' => $this->faker->firstName,
            'mname' => $this->faker->lastName,
            'lname' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'mobile' => $mobileNumber,
            'birthdate' => $this->faker->date,
            'email' => $this->faker->unique()->safeEmail,
            'course' => $this->faker->randomElement(['BSIT', 'BSHM', 'BSED', 'BEED']),
            'year' => $this->faker->randomElement([1, 2, 3, 4]),
            'section' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'address' => $this->faker->address,
        ];
    }
}
