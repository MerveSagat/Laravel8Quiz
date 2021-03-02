<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\MainController;
use App\Models\Question;

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

// Route::middleware(['auth:sanctum', 'verified'])->get('/panel', function () {
//     return view('dashboard');
// })->name('dashboard');  burayı videoda sildi yerine aşağıdaki grubu oluşturdu

Route::group(['middleware' => 'auth'], function () { // burada sadece adminlerin değil, diğer üyelerinde giriş yapıp yapmadığını kontrol ediyoruz
    Route::get('panel', [MainController::class, 'dashboard'])->name('dashboard');
    Route::get('quiz/detay/{slug}', [MainController::class, 'quizDetail'])->name('quiz.detail');//quizDetail bu main controllerdaki fonksiyonun adı
    Route::get('quiz/{slug}', [MainController::class, 'quiz'])->name('quiz.join');
    Route::post('quiz/{slug}/result', [MainController::class, 'result'])->name('quiz.result');
});

Route::group([
    'middleware' => ['auth', 'isAdmin'],
    'prefix' => 'admin' // bu yaptığımız işlemle url de http://localhost:8000/admin/deneme şeklinde, önde admin olacak şekilde çağırmak için bir tanımlama yapmış olduk
], function () {
    /*Route::get('deneme', function () {
        return 'prefix testi';
    });*/
    Route::get('quizzes/{id}', [QuizController::class, 'destroy'])->whereNumber('id')->name('quizzes.destroy'); //destroy methodunun üstüne yazdığımız ve program yukarıdan aşağı çalıştığı için bunu diğer satırın üstüne yazmamız önemli.Yoksa alttaki satırdaki destroyu çalıştırır önce
    Route::get('quizzes/{id}/details', [QuizController::class, 'show'])->whereNumber('id')->name('quizzes.details'); //destroy methodunun üstüne yazdığımız ve program yukarıdan aşağı çalıştığı için bunu diğer satırın üstüne yazmamız önemli.Yoksa alttaki satırdaki destroyu çalıştırır önce
    Route::get('quiz/{quiz_id}/questions/{id}', [QuestionController::class, 'destroy'])->whereNumber('id')->name('questions.destroy'); //Gidecek olan verilen mutlaka sayı olmak zorundadır.
    Route::resource('quizzes', QuizController::class);
    Route::resource('quiz/{quiz_id}/questions', QuestionController::class); //burada baştaki string tarayıcıda url de yazdığımız uzantıyı temsil ediyor
    //üst satırdaki quiz_id yazan yere, herhangi bir şey yazılabilir. anlamlı olması için böyle yazdık. herhangi bir yerden referans almıyor.
    //üst satırdaki uzantı çok uzun olmasına rağmen, list.blade de soru butonuna bunu tanımlarken sadece questions.index şeklinde yazmamız da yeterli oluyor. Son slash tan sonrası yeterli.

});
