<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBillingRequest extends FormRequest
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
            'appointment_id' => 'required',
            'name' => 'required|string',
            'email' => ['sometimes', 'nullable', 'string', 'lowercase', 'email', 'regex:/(.+)@(.+)\.(.+)/i', 'max:255'],
            'phone_number' => 'required|string|max_digits:10|min_digits:10',
            'address' => 'sometimes|nullable|string',
            'billing_date' => 'required|date_format:Y-m-d',
            'payment_mode' => ['required', 'string', 'in:cash,online'],
            'is_gst_bill' => 'required|boolean',
            'gst_percentage' => ['sometimes', 'nullable', 'numeric', 'required_if:is_gst_bill,true', function ($attribute, $value, $fail) {
                if ($this->is_gst_bill && $value <= 0) {
                    $fail($attribute . ' must be greater than 0 if GST is applied.');
                }
            }],
            'doctor_name' => 'required|string',
            'doctor_fees' => 'required|numeric',
            'clinical_test_information.*.test_id' => ['nullable', 'sometimes', 'required_with:schedule_of_work_information.*.test_id', 'integer'],
            'clinical_test_information.*.amount' => ['nullable', 'sometimes', 'required_with:schedule_of_work_information.*.amount', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'billing_date.date_format' => 'The bill date must be in the format Y-m-d.',
            'payment_mode.in' => 'The payment mode must be either cash or online.',
            'gst_percentage.required_if' => 'The GST percentage field is required when GST bill is checked.',
            'amount.required_with' => 'The Clinical Test amount is required when Clinical Test is present.',
            'clinical_test_information.*.test_id' => 'Clinical Test is required',
            'clinical_test_information.*.amount' => 'Clinical Test amount is required',
        ];
    }
}
