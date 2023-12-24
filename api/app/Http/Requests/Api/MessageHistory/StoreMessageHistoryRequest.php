<?php

namespace App\Http\Requests\Api\MessageHistory;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageHistoryRequest extends FormRequest
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
        // array:12 [ // app/Http/Requests/MessageHistory/StoreMessageHistoryRequest.php:14
        //     "body" => null
        //     "isDirty" => false
        //     "errors" => []
        //     "hasErrors" => false
        //     "processing" => false
        //     "progress" => null
        //     "wasSuccessful" => false
        //     "recentlySuccessful" => false
        //     "__rememberable" => true
        //     "user_id" => "1"
        //     "stylist_id" => "1"
        //     "from_user" => "1"
        //   ]
        return [
            'body' => ['required', 'string'],
            'user_id' => ['required', 'integer'],
            'stylist_id' => ['required', 'integer'],
            'from_user' => ['required', 'boolean'],
        ];
    }

    public function attributes()
    {
        return [
            'body' => 'メッセージ',
            'user_id' => 'ユーザーID',
            'stylist_id' => 'スタイリストID',
        ];
    }
}
