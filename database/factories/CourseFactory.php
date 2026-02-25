<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->sentence(3);
        return [
            'name' => $name,
            'description' => fake()->paragraph(),
            'cover_image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80',
            'slug' => \Illuminate\Support\Str::slug($name),
            'level_id' => \App\Models\Level::factory(),
            'created_by' => \App\Models\User::factory(),
             "price" => "100"
        ];
    }
}
