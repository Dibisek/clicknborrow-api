<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Book;

class StoreReservationRequest extends FormRequest
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
            'bookId' => ['required', 'integer', 'exists:books,id'],
            'userId' => ['required', 'integer', 'exists:users,id'],
            'startDate' => ['required', 'date', 'after:now', Rule::date()->format('Y-m-d')],
            'endDate' => ['required', 'date', 'after:from', Rule::date()->format('Y-m-d')],
            'status' => ['integer', 'default:0'], 
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'book_id' => (int) $this->bookId,
            'user_id' => (int) $this->userId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
    }
}
