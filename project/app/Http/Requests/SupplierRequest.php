<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{

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
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'                   => 'Department name is required!'
        ];
    }

  }  
