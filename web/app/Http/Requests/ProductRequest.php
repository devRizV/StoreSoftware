<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $rules = [
            'name'                          => 'required',
            'quantity'                      => 'required',
            'unit'                          => 'required',
            'quantityprice'                 => 'required',
            'totalprice'                    => 'required',
            'grandtotal'                    => 'required',
            'purchasedate'                  => 'required',
            'reqdept'                       => 'required',
            'supplier'                      => 'required'
            
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'                   => 'Product name is required!',
            'quantity.required'               => 'Product quantity is required!',
            'unit.required'                   => 'Product quantity unit is required!',
            'quantityprice.required'          => 'Product price is required!',
            'totalprice.required'             => 'Product total price is required!',
            'grandtotal.required'             => 'Product grand total is required',
            'purchasedate.required'           => 'Purchase date is required',
            'reqdept.required'                => 'Requisation department is required',
            'supplier.required'               => 'Supplier name is required'
        ];
    }

  }  
