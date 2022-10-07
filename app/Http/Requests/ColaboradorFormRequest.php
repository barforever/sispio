<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColaboradorFormRequest extends FormRequest
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
            'idcargo'=>'required',
            'idturno'=>'required',
            'nickname'=>'required|max:50',
            'nombres'=>'required|max:50',
            'apellidos'=>'required|max:50',
            'dni'=>'required|max:8',
            'direccion'=>'required|max:100',
            'telefono'=>'max:9'
        ];
    }
}
