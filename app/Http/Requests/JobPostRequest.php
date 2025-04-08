<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Make sure to allow the request
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'salary_range' => 'required|string|max:255',
            'description' => 'required|string',
            'applied_before' => 'nullable|date',
        ];
    }
}
