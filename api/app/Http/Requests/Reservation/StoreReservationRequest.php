<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'stylist' => ['required', 'array'],
            'stylist.name' => ['required', 'string'],
            'menus' => ['required', 'array'],
            'event' => ['required', 'array'],
        ];
    }

    public function attributes()
    {
        return [
            'stylist.name' => 'スタイリスト名',
            'menus' => 'メニュー',
            'event' => '予約',
        ];
    }
}
