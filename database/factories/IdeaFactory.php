<?php

namespace Database\Factories;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends Factory<Idea>
 */
/** @var \Faker\Generator $faker */

class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomUrls = array_map(fn () => fake()->url(), range(1, 5));

        $imageName = 'ideas/' . Str::uuid() . '.jpg';
        $imageContent = Http::get('https://picsum.photos/640/480')->body();
        Storage::disk('public')->put($imageName, $imageContent);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => fake()->sentence(),
            'image_path' => $imageName,
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(IdeaStatus::cases())->value,
            'links' => $this->faker->randomElements($randomUrls, rand(1, 5))
        ];
    }

    /**
     * Estado para criar uma sequência garantindo todos os status.
     */
    public function withUniqueStatuses(): static
    {
        return $this->sequence(
            ['status' => IdeaStatus::PENDING],
            ['status' => IdeaStatus::IN_PROGRESS],
            ['status' => IdeaStatus::COMPLETED],
        );
    }
}
