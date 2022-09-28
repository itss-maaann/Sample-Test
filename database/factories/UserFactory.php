<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->bothify('###########'), //This will generate phone number in string data-type as in migration i assigned string data-type for number, incase we wanted to generate number in integer type, we can use numerify()
            'email' => $this->faker->unique()->safeEmail(),
            'photo' => 'https://source.unsplash.com/random', //This will generate random images
            'email_verified_at' => now(),
            'password' => Hash::make('Majid_123'), //To bcrypt password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
