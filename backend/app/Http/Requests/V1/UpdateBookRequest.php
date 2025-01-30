<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
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
        $method = $this->getMethod();

        if ($method == 'PUT') {
            return [
                'title' => ['required', 'string', 'max:255'],
                'author' => ['required', 'string', 'max:255'],
                'publicationDate' => ['nullable', 'date', Rule::date()->format('Y-m-d')],
                'description' => ['required', 'string', 'max:1000'],
                'pageCount' => ['required', 'integer'],
                'categories' => ['required', 'array'],
                'categories.*' => ['required', 'string', 'max:255'],
            ];
        } else {
            return [
                'title' => ['sometimes', 'required', 'string', 'max:255'],
                'author' => ['sometimes', 'required', 'string', 'max:255'],
                'publicationDate' => ['sometimes', 'nullable', 'date', Rule::date()->format('Y-m-d')],
                'description' => ['sometimes', 'required', 'string', 'max:1000'],
                'pageCount' => ['sometimes', 'required', 'integer'],
                'categories' => ['sometimes', 'required', 'array'],
                'categories.*' => ['sometimes', 'required', 'string', 'max:255'],
            ];          
        }
    }

    protected function prepareForValidation()
    {
        if ($this->author) {
            $this->merge([
                'author_id' => Author::firstOrCreate(['name' => $this->author])->id,
            ]);
        }

        if ($this->pageCount) {
            $this->merge([
                'page_count' => $this->pageCount,
            ]);
        }
        
        if ($this->publicationDate) {
            $this->merge([
                'publication_date' => $this->publicationDate,
            ]);
        }

        if ($this->categories) {
            $categories = collect($this->categories)->map(function ($category) {
                if (is_numeric($category)) {
                    return Category::findOrFail($category)->id;
                }
                return Category::firstOrCreate(['category_name' => $category])->id;
            })->unique()->values()->toArray();

            $this->merge([
                'category_ids' => $categories,
            ]);
        }
    }
}