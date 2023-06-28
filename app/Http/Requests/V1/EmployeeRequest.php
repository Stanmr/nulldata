<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:employees',
            'position' => 'required|max:255',
            'date_of_birth' => 'required|max:255|date|date_format:d-m-Y',
            'address' => 'required|max:500',
            'skills.*.name'  => 'string|distinct',
            'skills.*.level'  => 'integer|between:1,5',
        ];
    }
}
