<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaFormRequest extends FormRequest
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
        //estamos dentro de la funcion publica rules (reglas), recuerda que los datos ingresados desde los
            //formularios html, pasaran por aqui para ser validados antes de ser guardos.
        return [
            'nombre'=>'required|max:50',//recuerda que 'nombre' no es el nombre del campo de la tabla, sino es el nombre de nuestro objeto en nuestro formulario html
            'tipo_documento'=>'required|max:50',
            'num_documento'=>'required|max:11',
            'direccion'=>'max:50',
            'telefono'=>'max:9',
            'f_nacimiento'=>'Nullable|date',
            'email'=>'max:50',
        ];
    }
}
