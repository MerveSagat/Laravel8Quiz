<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Result;

class MainController extends Controller
{
    public function dashboard()
    {
        $quizzes = Quiz::where('status', 'publish')->where(function($query){
            $query->whereNull('finished_at')->orWhere('finished_at','>',now()); //bu satırla, süresi biten quizi dashboardda herkesin görmemesi için listeden kaldırmaya yarıyor
        })->withCount('questions')->paginate(5);
        $results = auth()->user()->results; // bu kullanımla User::with('results') kullanımı aynı. İkisi de kullanılabilir.
        return view('dashboard', compact('quizzes', 'results')); //üst satırda çektiğimiz datayı, bu satırda compact ile view imize gönderiyoruz.
    }

    public function quiz($slug)
    {
        $quiz = Quiz::whereSlug($slug)->with('questions.my_answer','my_result')->first() ?? abort(404,'Quiz Bulunamadı');

        if($quiz->my_result) {
            return view('quiz_result', compact('quiz'));
        }

        return view('quiz', compact('quiz'));
    }

    public function quiz_detail($slug)
    {
        $quiz = Quiz::whereslug($slug)->with('my_result','topTen.user')->withCount('questions')->first() ?? abort(404, 'Quiz Bulunamadı');
        return view('quiz_detail', compact('quiz')); //burada soru sayısını alabilmek için üst satırda withCount fonk kullandık. Bunu ekrana yazdırmak için quiz_detail.blade.php de quiz->question_count olarak çağırdık.
    }

    public function result(Request $request, $slug)
    {
        $quiz = Quiz::with('questions')->whereSlug($slug)->first() ?? abort(404,'Quiz Bulunamadı'); //with wuestions ekleyerek slugını belirttiğimiz quizin tüm sorularına ulaşabiliriz
        $correct = 0;

        if($quiz->my_result){
            abort(404,'You have participated in this quiz before');
        }

        foreach($quiz->questions as $question) {
            echo $question->id.'- '.$question->correct_answer.'/'.$request->post($question->id).'<br>';
            Answer::create([
                'user_id'=>auth()->user()->id,//giriş yapmış kullanıcı olduğu için auth u ekledik
                'question_id'=>$question->id,
                'answer'=>$request->post($question->id)
            ]);

            // echo $question->correct_answer.'-'.$request->post($question->id).'<br>';

            
            if($question->correct_answer===$request->post($question->id)){
                $correct+=1;
            }
        }

         $point = round( (100 / count($quiz->questions) )* $correct);
         $wrong = count($quiz->questions)-$correct;

        Result::create([
            'user_id'=>auth()->user()->id,
            'quiz_id'=>$quiz->id,
            'point'=>$point,
            'correct'=>$correct,
            'wrong'=>$wrong,
        ]);

        return redirect()->route('quiz.detail',$quiz->slug)->withSuccess("Başarıyla Quiz'i bitirdin. Puanın: ".$point);
    }
}
