<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreChatRequest
 * @package App\Http\Requests
 */
class StoreChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'required',
            'to' => 'required', // 멘티타입_회원번호
            'from' => 'required', // 멘티타입_회원번호
        ];
    }
}
