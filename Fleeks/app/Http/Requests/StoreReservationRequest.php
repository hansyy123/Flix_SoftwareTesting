<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'movie_title' => ['required', 'string', Rule::in(array_merge(config('app.movies'), ['other']))],
            'manual_movie_title' => ['required_if:movie_title,other', 'nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date', 'after:now'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'payment_method' => ['required', Rule::in(['cash', 'gcash', 'bank_transfer'])],
            'payment_proof' => [
                Rule::requiredIf(fn () => in_array($this->input('payment_method'), ['gcash', 'bank_transfer'], true)),
                'nullable',
                'file',
                'max:5120',
                'mimes:jpg,jpeg,png,pdf',
            ],
        ];
    }
}

