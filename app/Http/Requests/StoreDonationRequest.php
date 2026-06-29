<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'campaign_id' => [
                'required',
                'exists:tb_campaigns,campaign_id'
            ],

            'amount' => [
                'required',
                'integer',
                'min:5000'
            ],

            'support_message' => [
                'nullable',
                'string',
                'max:500'
            ],

            'is_anonymous' => [
                'nullable',
                'in:yes,no'
            ]

        ];
    }

    public function messages(): array
    {
        return [

            'campaign_id.required' =>
                'Campaign tidak ditemukan.',

            'campaign_id.exists' =>
                'Campaign tidak valid.',

            'amount.required' =>
                'Nominal donasi wajib diisi.',

            'amount.integer' =>
                'Nominal harus berupa angka.',

            'amount.min' =>
                'Minimal donasi Rp5.000.',

            'support_message.max' =>
                'Pesan maksimal 500 karakter.',

            'is_anonymous.in' =>
                'Status anonim tidak valid.'

        ];
    }

    protected function prepareForValidation(): void
    {
        $amount = preg_replace('/[^\d]/', '', (string) $this->input('amount'));

        $this->merge([
            'amount' => (int) $amount,
            'is_anonymous' => $this->boolean('is_anonymous') ? 'yes' : 'no',
        ]);
    }
}
