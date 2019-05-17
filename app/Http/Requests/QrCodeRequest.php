<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QrCodeRequest extends FormRequest
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
        $qrType = $this->request->get('qr-type');
        $rules = [];

        switch ($qrType) {
            case 'url':
                $rules = ['url' => 'required|url'];
                break;
            case 'email':
                break;
            case 'geo':
                break;
            case 'phone':
                break;
            case 'sms':
                break;
            case 'wifi':
                break;
        }

        return $rules;
    }

    public function messages()
    {
        flash()->error('필수 값이 누락되었습니다.');
        return [
            'title.required' => '필수 값이 누락되었습니다.'
        ];
    }
}
