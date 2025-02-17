<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStorageRequest extends FormRequest
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
            'name'                          => 'required|array',
            'name.*'                        => 'required|integer|exists:prd_name,pk_no',
            'quantity'                      => 'required|array',
            'quantity.*'                    => 'required|numeric|min:0',
            'unit'                          => 'required|array',
            'unit.*'                        => 'required|string',
            'quantityprice'                 => 'required|array',
            'quantityprice.*'               => 'required|numeric|min:0',
            'totalprice'                    => 'required|array',
            'totalprice.*'                  => 'required|numeric|min:0',
            'takendate'                     => 'required|date',
            'reqdept'                       => 'required|string',
            'takenby'                       => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.*.required'                   => 'Product name is required!',
            'takenby.required'                  => 'Product taken by is required!',
            'takendate.required'                => 'Product taken date is required!',
            'quantity.*.required'               => 'Product quantity is required!',
            'unit.*.required'                   => 'Product unit is required!',
            'quantityprice.*.required'          => 'Product price is required!',
            'totalprice.*.required'             => 'Product total price is required!',
            'reqdept.required'                  => 'Department name is required!'
        ];
    }
}  
