<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'gender_id' => 1, // Assuming male gender ID is 1
            'middle_name' => $this->faker->firstName,
            'suffix_name' => $this->faker->suffix,
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address,
            'contact_number' => $this->faker->phoneNumber,
            'username' => 'admin',
            'photo' => '', // Assuming default photo name
            'password' => bcrypt('admin'), // Assuming default password
        ];
    }
}
