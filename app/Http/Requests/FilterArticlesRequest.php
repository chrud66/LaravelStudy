<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterArticlesRequest extends FormRequest
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
            'f' => 'in:nocomment,notsolved',
            's' => 'in:created_at,view_count',
            'd' => 'in:asc,desc',
            'q' => 'alpha_dash'
        ];
    }
}
