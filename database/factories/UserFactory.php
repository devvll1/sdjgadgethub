<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => fake()->unique()->safeEmail(),
            'gender_id' => 1,
            'middle_name' => fake()->firstName(),
            'suffix_name' => fake()->suffix(),
            'birth_date' => fake()->date(),
            'address' => fake()->address(),
            'contact_number' => fake()->phoneNumber(),
            'username' => fake()->unique()->userName(),
            'role' => 'admin',
            'photo' => '',
            'password' => 'password',
        ];
    }
}
