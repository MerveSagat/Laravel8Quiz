<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //burası oturumun açık mı kapalı mı olduğunu belirtiyor. Varsayılan olarak false geliyor. Eğer false olarak kalırsa oturum kapalı anlamına gelir. Biz validasyonu oturum açıkken yapacağımız için burayı true olarak ayarlıyoruz.
        //validation kurallarını alttaki rules fonksiyonunda yazıyoruz
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:200',
            'description' => 'max:1000',
            'finished_at' => 'nullable|after:'.now()//tarih boş bırakılabilir olması için nullable kullanıyoruz.
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Quiz Başlığı',
            'description' => 'Quiz Açıklama',
            'finished_at' => 'Bitiş Tarihi'
        ];
    }
}
