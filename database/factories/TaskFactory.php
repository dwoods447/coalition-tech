<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $titles = [
            "Wash the Dishes",
            "Type a report",
            "Build a club house",
            "Learn new programming language",
            "Walk the dog",
            "Empty the trash"
        ];

        $title = $this->faker->unique()->randomElement($titles);
        return [
            //
            'title' => $title,
            'content' => $this->faker->paragraph,
        ];
    }
}
