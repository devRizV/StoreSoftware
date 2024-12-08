<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                          => 'required',
            'quantity'                      => 'required',
            'unit'                          => 'required',
            'quantityprice'                 => 'required',
            'totalprice'                    => 'required',
            'purchasedate'                  => 'required',
            'reqdept'                       => 'required',
            'supplier'                      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'                   => 'Product name is required!',
            'quantity.required'               => 'Product quantity is required!',
            'unit.required'                   => 'Product quantity unit is required!',
            'quantityprice.required'          => 'Product price is required!',
            'totalprice.required'             => 'Product total price is required!',
            'purchasedate.required'           => 'Purchase date is required',
            'reqdept.required'                => 'Requisation department is required',
            'supplier.required'               => 'Supplier name is required',
        ];
    }
}
