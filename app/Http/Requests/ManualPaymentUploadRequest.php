<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManualPaymentUploadRequest extends FormRequest
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
            'payment_channel'   => 'required|string|max:100',
            'payment_proof'     => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'selected_items'    => 'required|array|min:1',
            'selected_items.*'  => [
                'integer',
                'exists:invoice_items,id',
            ],
        ];
    }
}
