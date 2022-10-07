<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoFormRequest extends FormRequest
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
            'idproveedor'=>'nullable',
            'tipo_comprobante'=>'nullable',
            'serie_comprobante'=>'nullable',
            'num_comprobante'=>'nullable',
            'monto_total'=>'required',
            'idinsumo'=>'required',
            'cantidad'=>'required',
            'precio_compra'=>'required'
        ];
    }
}
