<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('product');
        return [
            'serial' => ['required',
                Rule::unique('products')->ignore($id, 'id'),
            ],
            'title' => 'required',
            'price' => 'required|numeric|min:0',
            'genre' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000000',
            'description' => 'required',
            'is_active' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            'serial.required' => 'The serial number is required.',
            'serial.unique' => 'The serial number must be unique.',
            'title.required' => 'The title is required.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least :min.',
            'image.required' => 'An image is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be in one of the following formats: jpeg, png, jpg, gif.',
            'image.max' => 'The image size must be less than :max kilobytes.',
            'description.required' => 'The description is required.',
            'is_active.boolean' => 'The active/inactive field must be true or false.'
        ];
    }

}
