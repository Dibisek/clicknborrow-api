<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReservationRequest extends FormRequest
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

        if ($method === 'PUT') {
            return [
                'bookId' => ['required', 'integer', 'exists:books,id'],
                'userId' => ['required', 'integer', 'exists:users,id'],
                'startDate' => ['required', 'date', 'after:now', Rule::date()->format('Y-m-d')],
                'endDate' => ['required', 'date', 'after:from', Rule::date()->format('Y-m-d')],
            ];
        } else {
            return [
                'bookId' => ['sometimes', 'required', 'integer', 'exists:books,id'],
                'userId' => ['sometimes', 'required', 'integer', 'exists:users,id'],
                'startDate' => ['sometimes', 'required', 'date', 'after:now', Rule::date()->format('Y-m-d')],
                'endDate' => ['sometimes', 'required', 'date', 'after:from', Rule::date()->format('Y-m-d')],
                'status' => ['sometimes', 'integer'],
            ];
        }
    }

    public function prepareForValidation()
    {
        if ($this->bookId) {
            $this->merge([
                'book_id' => $this->bookId,
            ]);
        }

        if ($this->userId) {
            $this->merge([
                'user_id' => $this->userId,
            ]);
        }

        if ($this->startDate) {
            $this->merge([
                'start_date' => $this->startDate,
            ]);
        }

        if ($this->endDate) {
            $this->merge([
                'end_date' => $this->endDate,
            ]);
        }
    }
}
