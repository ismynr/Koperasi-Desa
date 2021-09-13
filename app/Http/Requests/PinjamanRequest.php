<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PinjamanRequest extends FormRequest
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
            'jml_pinjaman' => 'required|numeric|digits_between:5,11',
            'tenor' => 'required|numeric|digits_between:1,2',
            'total_pinjaman' => 'required|numeric|digits_between:5,11',
            'tujuan_pinjaman' => 'required',
        ];
    }
}
