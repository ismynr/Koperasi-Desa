<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TabunganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'jenis_tabungan_id' => 'required|numeric',
            'jml_tabungan' => 'required|numeric|digits_between:5,11',
        ];
    }
}
