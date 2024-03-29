<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $rules = [
            'name'                          => 'required',
            'takenby'                       => 'required',
            'takendate'                     => 'required',
            'quantity'                      => 'required',
            'unit'                          => 'required',
            'quantityprice'                 => 'required',
            'totalprice'                    => 'required',
            'grandtotal'                    => 'required',
            'reqdept'                       => 'required'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'                   => 'Product name is required!',
            'takenby.required'                => 'Product taken by is required!',
            'takendate.required'              => 'Product taken date is required!',
            'quantity.required'               => 'Product quantity is required!',
            'unit.required'                   => 'Product quantity unit is required!',
            'quantityprice.required'          => 'Product price is required!',
            'totalprice.required'             => 'Product total price is required!',
            'grandtotal.required'             => 'Product grand total is required',
            'reqdept.required'                => 'Department can not be empty !!'
        ];
    }

  }  
