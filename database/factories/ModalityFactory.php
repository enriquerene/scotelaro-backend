<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Modality>
 */
class ModalityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'color' => $this->faker->hexColor(),
            'icon' => $this->faker->randomElement([
                'heroicon-o-academic-cap',
                'heroicon-o-beaker',
                'heroicon-o-bolt',
                'heroicon-o-book-open',
                'heroicon-o-cube',
                'heroicon-o-fire',
                'heroicon-o-globe-alt',
                'heroicon-o-heart',
                'heroicon-o-lightning-bolt',
                'heroicon-o-musical-note',
                'heroicon-o-puzzle-piece',
                'heroicon-o-shield-check',
                'heroicon-o-star',
                'heroicon-o-trophy',
                'heroicon-o-user-group',
            ]),
            'image' => null,
            'is_active' => true,
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }

    /**
     * Create default modalities for production.
     */
    public function defaultModalities(): array
    {
        $defaults = [
            [
                'name' => 'Muay Thai',
                'description' => 'Thai boxing martial art',
                'color' => '#ef4444', // red
                'icon' => 'heroicon-o-fire',
                'order' => 1,
            ],
            [
                'name' => 'Luta Livre',
                'description' => 'Brazilian submission wrestling',
                'color' => '#3b82f6', // blue
                'icon' => 'heroicon-o-bolt',
                'order' => 2,
            ],
            [
                'name' => 'MMA',
                'description' => 'Mixed Martial Arts',
                'color' => '#8b5cf6', // purple
                'icon' => 'heroicon-o-shield-check',
                'order' => 3,
            ],
            [
                'name' => 'Boxe',
                'description' => 'Boxing',
                'color' => '#f59e0b', // amber
                'icon' => 'heroicon-o-trophy',
                'order' => 4,
            ],
            [
                'name' => 'Jiu-Jitsu',
                'description' => 'Brazilian Jiu-Jitsu',
                'color' => '#10b981', // emerald
                'icon' => 'heroicon-o-puzzle-piece',
                'order' => 5,
            ],
            [
                'name' => 'Capoeira',
                'description' => 'Brazilian martial art that combines elements of dance, acrobatics, and music',
                'color' => '#f97316', // orange
                'icon' => 'heroicon-o-musical-note',
                'order' => 6,
            ],
        ];

        return $defaults;
    }
}
