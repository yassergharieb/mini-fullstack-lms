<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);
        return [
            'course_id' => \App\Models\Course::factory(),
            'title' => $title,
            'description' => fake()->paragraph(),
            'slug' => \Illuminate\Support\Str::slug($title),
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'duration' => fake()->numberBetween(300, 1800),
            'order' => fake()->numberBetween(1, 10),
            'published' => true,
            'is_free_preview' => false,
        ];
    }
}
