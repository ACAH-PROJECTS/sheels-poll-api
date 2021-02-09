<?php

namespace Database\Factories;

use App\Models\SurveyTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SurveyTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'sections_count' => 10,
            'questions_count' => 10,
        ];
    }
}
