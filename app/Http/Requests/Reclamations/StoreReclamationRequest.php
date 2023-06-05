<?php

namespace App\Http\Requests\Reclamations;


use Illuminate\Foundation\Http\FormRequest;

class StoreReclamationRequest extends FormRequest
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
            //
            'objet' => 'required|string|max:30',
            'solution' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'cnamId' => 'required|string|max:12',
            'description' => 'nullable',
        ];
    }
}
