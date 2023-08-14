<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
        return [
            "category_id" => "required",
            "amount" => "numeric|gt:0|required",
            "user_id" => "required",
            "entry_date" => "required",
        ];
    }

    public function messages(){
        return [
            "amount.numeric" => "Please enter valid monetary amount.",
            "amount.gt:0" => "Amount must be greater than 0."
        ];
    }
}
