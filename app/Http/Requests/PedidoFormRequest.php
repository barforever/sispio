<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoFormRequest extends FormRequest
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
            'idmozo'=>'required',
            'idmesa'=>'required',
            'num_comanda'=>'required|numeric',
            'idproducto'=>'required',
            'cantidad'=>'required',
            'precio_venta'=>'required'
        ];
    }
}
