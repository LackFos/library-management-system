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
            'title' => 'bail|required|string|min:3|max:255|unique:books',
            'author' => 'bail|required|string|min:3|max:255',
            'isbn' => 'bail|required|string|unique:books|digits_between:10,13',
            'publisher' => 'bail|required|string|min:3|max:255',
            'publication_date' => 'bail|required|date',
            'quantity' => 'bail|required|integer'
        ];
    }
}
