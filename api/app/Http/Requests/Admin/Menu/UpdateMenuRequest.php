<?php

namespace App\Http\Requests\Admin\Menu;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', [$this->route('menu'), $this->route('shop')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'メニュー名を入力してください',
            'name.string' => 'メニュー名は文字列で入力してください',
            'name.max' => 'メニュー名は255文字以内で入力してください',
            'price.required' => '価格を入力してください',
            'price.integer' => '価格は整数で入力してください',
        ];
    }
}