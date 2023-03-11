<?php

namespace App\Http\Requests\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'CNAMID' => 'required|string|max:12',
            'SPECIALITE' => 'required',
            'SHORTNAME' => 'required',
            'FAMNAME' => 'required',
            'GOUVNAME' => 'required',
            'LOCALITE' => 'required',
            'ADRESSE' => 'required',
            'GSM' => 'nullable|numeric|digits:8',
            'TELEPHONE' => 'required|numeric|digits:8',
        ];
    }
}
