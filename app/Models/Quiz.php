<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

class Quiz extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'description',
        'status',
        'finished_at',
        'slug'
    ];

    protected $dates = ['finished_at'];
    protected $appends = ['details','my_rank']; //getDetailsAttribute te return ettirdiğimiz veriyi buradaki sütun başlığı altında yani details altında gösteriyoruz. Modeli bulması için bu şart.

    public function getDetailsAttribute() //burada veritabanında ilgili tabloda öyle bir sütun olmamasına rağmen varmış gibi göstermemize yarayan bir laravel özelliği. isim verirken get diyoruz, sonra istediğimiz herhangi bir şey yazıp, attribute diyoruz.mutation diyoruz buna.
    {
        if ($this->results()->count() > 0) {
            return [
                'average' => round($this->results()->avg('point')),
                'join_count' => $this->results()->count()
            ];
        }
    }

    public function getMyRankAttribute() //bu attribute ü yine yukarıda appends e ekledik.
    {
        //işlemi yapmak için önce en yüksek puandan aşağı doğru sıralıyoruz.
        //sonra kendi derecemizi getiriyoruz.
        $rank = 0;
        foreach($this->results()->orderByDesc('point')->get() as $result) {
            $rank+=1;
            if(auth()->user()->id==$result->user_id){ //benim user_id ile resulttaki id esşitse derecemi göster
                return $rank;
            }

        }

    }

    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }

    public function topTen()
    {
        return $this->results()->/*önce bunu yazarak tüm sonuçları getirdik, sonra order by ile sıralıyoruz*/ 
        orderByDesc('point')->take(10);//take fonk. ihtiyacımız kadar veri getirmeye yarıyor
    }

    public function my_result()
    {
        return $this->hasOne('App\Models\Result')->where('user_id', auth()->user()->id);
    }

    public function getFinishedAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [ //burası db deki sütunun adı. Yani sütun adı başka olsaydı onu yazacaktık.
                'source' => 'title'  //kaynağını nereden alacak? sluglanacak veri title. burada bunu belirtiyor.
            ]
        ];
    }
}
