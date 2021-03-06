<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Http\Requests\QuestionCreateRequest;
use App\Http\Requests\QuestionUpdateRequest;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $quiz = Quiz::whereId($id)->with('questions')->first() ?? abort(404, 'Quiz Bulunamadı'); //bu çağırma yönteminde tek satırda hem quiz bilgisini hem de o quize ait sorulara ulaşabiliyoruz.
        return view('admin.question.list', compact('quiz'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) //normalde burası parametresiz geliyor. Biz  parametre ekleyerek url de gelen sorunun id sini yakalayabiliyoruz
    {
        $quiz = Quiz::find($id);
        return view('admin.question.create', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionCreateRequest $request, $id)
    {
        if ($request->hasFile('image')) {
            $fileName = Str::slug($request->question) . '.' . $request->image->extension();
            $fileNameWithUpload = 'uploads/' . $fileName;
            $request->image->move(public_path('uploads'), $fileName); //bu satır projenin içine kaydedilmesini sağlar. sonrasında bir de db deki sütuna kaydetmek lazım.
            $request->merge([
                'image' => $fileNameWithUpload
            ]); //bu da db ye kaydediyor.
        }
        Quiz::find($id)->questions()->create($request->post());

        return redirect()->route('questions.index', $id)->withSuccess('Soru başarıyla oluşturuldu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($quizId, $id) //parametreyi bu şekilde 2 tane yazarsak, önce quizin idsini, sonra sorunun id sini yakalayabiliriz.
    {
        return $quizId . '-' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($quizId, $questionId)
    {
        $question = Quiz::find($quizId)->questions()->whereId($questionId)->first() ?? abort(404, 'Quiz or Question Not Found');
        return view('admin.question.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionUpdateRequest $request, $quizId, $questionId)
    {
        if ($request->hasFile('image')) {
            $fileName = Str::slug($request->question) . '.' . $request->image->extension();
            $fileNameWithUpload = 'uploads/' . $fileName;
            $request->image->move(public_path('uploads'), $fileName); //bu satır projenin içine kaydedilmesini sağlar. sonrasında bir de db deki sütuna kaydetmek lazım.
            $request->merge([
                'image' => $fileNameWithUpload
            ]); //bu da db ye kaydediyor.
        }
        Quiz::find($quizId)->questions()->whereId($questionId)->first()->update($request->post());

        return redirect()->route('questions.index', $quizId)->withSuccess('Question has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($quizId, $questionId)
    {
        Quiz::find($quizId)->questions()->whereId($questionId)->delete();
        return redirect()->route('questions.index', $quizId)->withSuccess('Question has been deleted successfully');
    }
}
