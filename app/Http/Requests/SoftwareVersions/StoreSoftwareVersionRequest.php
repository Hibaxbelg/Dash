<?php

namespace App\Http\Requests\SoftwareVersions;

use Illuminate\Foundation\Http\FormRequest;

class StoreSoftwareVersionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'min_pc_number' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'price_per_additional_pc' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'tva' => 'required|numeric|min:0|max:100|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }
}
