<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductNameRequest extends FormRequest
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
            'name'                          => 'required|string|min:2|max:255',
            'unit'                          => 'required|string|min:2|max:255',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'                   => 'Product name is required!',
            'unit.required'                   => 'Product unit is required!'
        ];
    }

  }  
