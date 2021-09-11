<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class AnggotaUpdateRequest extends FormRequest
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
        $anggota = $this->route('anggota');
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id,'.$anggota->user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'nama' => ['required'],
            'jk' => ['required'],
            'pekerjaan' => ['required'],
            'no_hp' => ['required'],
            'alamat' => ['required'],
            'narek' => ['required'],
            'norek' => ['required'],
        ];
    }
}
