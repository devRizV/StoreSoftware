<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;



class MultiProductRequest extends FormRequest
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

    /*
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {

        $req =  [
            'name'                          => 'required|array',
            'name.*'                        => 'required|string|exists:prd_name,pk_no',
            'quantity'                      => 'required|array',
            'quantity.*'                    => 'required|numeric|min:0',
            'unit'                          => 'required|array',
            'unit.*'                        => 'required|string',
            'quantityprice'                 => 'required|array',
            'quantityprice.*'               => 'required|numeric|min:0',
            'totalprice'                    => 'required|array',
            'totalprice.*'                  => 'required|numeric|min:0',
            'purchasedate'                  => 'required|date',
            'reqdept'                       => 'required|string',
            'supplier'                      => 'required|string',
        ];
        return $req;
    }

    public function messages()
    {
        return [
            'name.*.required'                   => 'Product name is required!',
            'quantity.*.required'               => 'Product quantity is required!',
            'unit.*.required'                   => 'Product quantity unit is required!',
            'quantityprice.*.required'          => 'Product price is required!',
            'totalprice.*.required'             => 'Product total price is required!',
            'purchasedate.required'             => 'Purchase date is required',
            'reqdept.required'                  => 'Requisition department is required',
            'supplier.required'                 => 'Supplier name is required',
        ];
    }
}
