<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class MainController extends Controller
{
    public function dashboard()
    {
        $quizzes = Quiz::where('status', 'publish')->withCount('questions')->paginate(5);
        return view('dashboard', compact('quizzes')); //üst satırda çektiğimiz datayı, bu satırda compact ile view imize gönderiyoruz.
    }

    public function quiz_detail($slug)
    {
        $quiz = Quiz::whereslug($slug)->withCount('questions')->first() ?? abort(404,'Quiz Bulunamadı');
        return view('quiz_detail',compact('quiz'));//burada soru sayısını alabilmek için üst satırda withCount fonk kullandık. Bunu ekrana yazdırmak için quiz_detail.blade.php de quiz->question_count olarak çağırdık.
    }
}
