<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->product->id ?? '';

        $rules = [
            'name' => 'required|string|min:3|max:100|unique:products,name,{$id},id',
            'price' => 'string|required',
            'stock' => 'integer|nullable',
            'description' => 'string|required',
            'cover' => [
                'file',
                'nullable',
                'mimes:jpg,png'
            ],
        ];

        if ($this->method('PUT')) {
            $rules['name'] = [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('products')->ignore($id)
            ];
        }

        return $rules;
    }
}
