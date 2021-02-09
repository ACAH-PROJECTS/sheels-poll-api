<?php

namespace App\Http\Controllers;

use App\Http\Resources\SurveyTemplateCollection;
use App\Models\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyTemplateController extends Controller
{

    public function __construct()
    {
        $this->middleware(['api.manager']);
        $this->middleware(['api.admin'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SurveyTemplateCollection::collection(SurveyTemplate::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SurveyTemplate  $surveyTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyTemplate $surveyTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SurveyTemplate  $surveyTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyTemplate $surveyTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SurveyTemplate  $surveyTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyTemplate $surveyTemplate)
    {
        //
    }
}
