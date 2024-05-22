<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'suffix_name' => fake()->suffix(),
            'birth_date' => fake()->date(),
            'gender_id' => fake()->numberBetween($min = 1, $max = 2),
            'address' => fake()->streetAddress(),
            'contact_number' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->userName(),
            'password' => bcrypt('123'),
        ];
    }
}
