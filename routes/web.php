<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuizController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/panel', function () {
    return view('dashboard');
})->name('dashboard');

Route::group([
    'middleware' => ['auth', 'isAdmin'],
    'prefix' => 'admin' // bu yaptığımız işlemle url de http://localhost:8000/admin/deneme şeklinde, önde admin olacak şekilde çağırmak için bir tanımlama yapmış olduk
], function () {
    /*Route::get('deneme', function () {
        return 'prefix testi';
    });*/
    Route::get('quizzes/{id}',[QuizController::class,'destroy'])->whereNumber('id')->name('quizzes.destroy');//destroy methodunun üstüne yazdığımız ve program yukarıdan aşağı çalıştığı için bunu diğer satırın üstüne yazmamız önemli.Yoksa alttaki satırdaki destroyu çalıştırır önce
    Route::resource('quizzes',QuizController::class);
    
});
