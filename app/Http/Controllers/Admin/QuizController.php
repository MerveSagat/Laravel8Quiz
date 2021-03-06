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
        //searchün butonsuz çalışması için aşağıdaki şekilde başlıktan yakalamalar yaparak sorgu yazıoruz
        $quizzes = Quiz::withCount('questions');
        if (request()->get('title')) { //burada get methoduyla başlığa gelen title ı yakalıyoruz
            $quizzes = $quizzes->where('title', 'LIKE', '%' . request()->get("title") . '%'); //kullanıcının aradığı başlık sistemde var mı bunu sorguluyoruz
        }

        if (request()->get('status')) {
            $quizzes = $quizzes->where('status', request()->get('status'));
        }

        //yukarıdaki iki filtreyi geçtikten sonra istenen verileri aşağıdaki şekilde lisyteliyoruz

        $quizzes = $quizzes->paginate(5); // bunu 5 yaparak tek sayfada 5 kayıt gösterilmesini sağladık. tamamını görmek için list.blaade de link vermemiz gerekiyor.
        return view('admin.quiz.list', compact('quizzes'));
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
    public function store(QuizCreateRequest $request) //burada varsayılan olarak request sınıfı geliyor, biz kullanacağımız request sınıfı ile değiştiriyoruz onu
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
        $quiz = Quiz::with('topTen.user', 'results.user')->withCount('questions')->find($id) ?? abort(404, 'Quiz Bulunamadı');

        return view('admin.quiz.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::withCount('questions')->find($id) ?? abort(404, 'Quiz bulunamadı');
        return view('admin.quiz.edit', compact(('quiz')));
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
        $quiz = Quiz::find($id) ?? abort(404, 'Quiz bulunamadı');
        Quiz::find($id)->update($request->except(['_method', '_token']));
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
        $quiz = Quiz::find($id) ?? abort(404, 'Quiz Bulunamadı');
        $quiz->delete();
        return redirect()->route('quizzes.index')->withSuccess('Quiz silme işlemi başarıyla gerçekleşti');
    }
}
