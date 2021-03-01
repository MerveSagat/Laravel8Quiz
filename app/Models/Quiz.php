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
        'finished_at',
        'slug'
    ];

    protected $dates = ['finished_at'];
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
