<?php

namespace App\Http\Requests\SaleSource;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
class SaleSourceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('sale_source-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'id' => 'required|exists:sale_sources,id'
        ];
    }
}