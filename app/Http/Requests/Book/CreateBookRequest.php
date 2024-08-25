<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'title' => 'bail|required|min:3|max:255|unique:books',
            'author' => 'bail|required|min:3|max:255',
            'isbn' => 'bail|required|unique:books|digits_between:10,13',
            'publisher' => 'bail|required|min:3|max:255',
            'publication_date' => 'bail|required|date',
            'stock' => 'bail|required|integer|min:0',
            'image' => 'bail|nullable|image|max:5120',
            "description" => 'bail|nullable|max:255'
        ];
    }
}
