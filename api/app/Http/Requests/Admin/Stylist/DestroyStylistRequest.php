<?php

namespace App\Http\Requests\Admin\Stylist;

use Illuminate\Foundation\Http\FormRequest;

class DestroyStylistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('delete', [$this->route('stylist'), $this->route('shop')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
