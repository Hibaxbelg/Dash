<?php

namespace App\Http\Requests\Orders;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreOrderRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,RECORD_ID',
            'product_id' => 'required|exists:products,id',
            'licenses' => 'required|integer|min:1', //validated min
            'os' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'distance' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'note' => 'nullable',
            'payment_by' => 'required',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($this->product_id != null) {
                $product = Product::find($this->product_id);
                if ($this->licenses < $product->min_pc_number) {
                    $validator->errors()->add('licenses', 'Au moins ' . $product->min_pc_number . ' licences pour le produit ' . $product->name);
                }
            }
        });
    }
}
