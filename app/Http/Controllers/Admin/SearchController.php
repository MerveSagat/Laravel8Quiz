<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

   

  
}
