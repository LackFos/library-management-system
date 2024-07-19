<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ["bail", "string", "min:3", "max:255", Rule::unique('books')->ignore($this->book->id)],
            'author' => 'bail|string|min:3|max:255',
            'isbn' => ["bail", "string", "digits_between:10,13", Rule::unique('books')->ignore($this->book->id)],
            'publisher' => 'bail|string|min:3|max:255',
            'publication_year' => 'bail|string|min:4|max:4',
            'quantity' => 'bail|integer'
        ];
    }
}
