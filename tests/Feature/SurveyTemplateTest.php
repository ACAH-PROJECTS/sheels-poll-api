<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SurveyTemplateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_admin_can_listed_of_survey_templates()
    {

        Factory::create(SurveyTemplate::class, 5);

        $response = $this->get(route('survey-template.index'), $this->headers);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            "data" => [
                "*" => [
                    "id",
                    "title",
                    "total_sections",
                    "total_quiestion"
                ]
            ]
        ]);
    }
}
