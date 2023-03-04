<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'CNAMID' => 'required|numeric|max:12',
            'FAMNAME' => 'required',
            'SHORTNAME' => 'required',
            'SPECIALITE' => 'required',
            'GSM' => 'required|numeric|min:8|max:8',
        ];
    }
}
