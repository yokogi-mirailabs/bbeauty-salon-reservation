<?php

namespace App\Http\Requests\Admin\Stylist;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStylistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', [$this->route('stylist'), $this->route('shop')]);
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
            'description' => ['required', 'string', 'max:255'],
            'job_post' => ['required', 'integer'],
            'speciality' => ['required', 'string', 'max:255'],
            'working_year' => ['required', 'integer'],
            'menus' => ['required', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'スタイリスト名を入力してください',
            'name.string' => 'スタイリスト名は文字列で入力してください',
            'name.max' => 'スタイリスト名は255文字以内で入力してください',
            'description.required' => '説明を入力してください',
            'description.string' => '説明は文字列で入力してください',
            'description.max' => '説明は255文字以内で入力してください',
            'job_post.required' => '役職を入力してください',
            'job_post.integer' => '役職は整数で入力してください',
            'speciality.required' => '得意なスタイルを入力してください',
            'speciality.string' => '得意なスタイルは文字列で入力してください',
            'speciality.max' => '得意なスタイルは255文字以内で入力してください',
            'working_year.required' => '経験年数を入力してください',
            'working_year.integer' => '経験年数は整数で入力してください',
            'menus.required' => 'メニューを選択してください',
            'menus.array' => 'メニューは配列で入力してください',
        ];
    }
}