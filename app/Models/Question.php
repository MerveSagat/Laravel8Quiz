<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'correct_answer',
        'image'
    ];

    protected $appends = ['true_percent'];//2.kelime büyük harfle başladığı için araya alt tire gerekiyor

    public function getTruePercentAttribute() 
    {
        $answerCount = $this->answers()->count();//burada cevapların kendisine ihtiyacımız olsa get() diyecektik ama sayısına ihtiyacımız olduğu için count diyoruz.
        $trueAnswer = $this->answers()->where('answer',$this->correct_answer)->count();

        return round((100/$answerCount) * $trueAnswer);
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }

    public function my_answer()
    {
        return $this->hasOne('App\Models\Answer')->where('user_id',auth()->user()->id); //bunu tanımladıktan sonra main kontrollerda bunu çağırıyoruz
    }
}
