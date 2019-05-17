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
        $rules = ['qr-type' => 'required|in:url,email,geo,phone,sms,wifi'];

        switch ($qrType) {
            case 'url':
                $rules[$qrType] = 'required|url';
                break;
            case 'email':
                $rules[$qrType] = 'required|numeric';
                break;
            case 'geo':
                $rules[$qrType.'1'] = 'required|numeric';
                $rules[$qrType.'2'] = 'required|numeric';
                break;
            case 'phone':
                $rules[$qrType] = 'required|numeric';
                break;
            case 'sms':
                $rules[$qrType.'1'] = 'required|numeric';
                $rules[$qrType.'2'] = 'required|string';
                break;
            case 'wifi':
                $rules[$qrType] = 'required|string';
                break;
        }

        return $rules;
    }

public function messages()
    {
        flash()->error('잘못된 타입의 요청입니다.');
        return [
            'qr-type.required' => '잘못된 타입 요청입니다.',
            'url.numeric' => '잘못된 형식의 값입니다.'
        ];
    }
}
