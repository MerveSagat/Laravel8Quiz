<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Http\Requests\QuizCreateRequest; //kullanacağımız sayfaları bu şekilde önce çağırmamız gerekiyor controller içinden
use App\Http\Requests\QuizUpdateRequest;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::paginate(5); // bunu 5 yaparak tek sayfada 5 kayıt gösterilmesini sağladık. tamamını görmek için list.blaade de link vermemiz gerekiyor.
        return view('admin.quiz.list',compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizCreateRequest $request)//burada varsayılan olarak request sınıfı geliyor, biz kullanacağımız request sınıfı ile değiştiriyoruz onu
    {
        //return $request->post(); //burada bu şekilde kullanırsak requestten gelen tüm verileri ekrana basar.
        Quiz::create($request->post());
        return redirect()->route('quizzes.index')->withSuccess('Quiz Başarıyla Oluşturuldu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::find($id) ?? abort(404,'Quiz bulunamadı');
        return view('admin.quiz.edit',compact(('quiz')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuizUpdateRequest $request, $id) //Request oluşturduktan ve yukarıda use ile çağırdıktan sonra, buradaki request sınıfını kendi gereken request sınıfı ile değiştiriyoruz
    {
        $quiz = Quiz::find($id) ?? abort(404,'Quiz bulunamadı');
        Quiz::where('id',$id)->update($request->except(['_method','_token']));
        return redirect()->route('quizzes.index')->withSuccess('Quiz güncelleme işlemi başarıyla gerçekleşti');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
