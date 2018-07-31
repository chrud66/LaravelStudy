<?php

namespace App\Http\Requests;

class ArticlesRequest extends Request
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
        $rules = [];

        if ($this->isDelete()) {
            $rules = [];
        } elseif ($this->isUpdate()) {
            // update 요청일 때와 아닐 때로 유효성 검사 규칙을 분리했다.
            $rules = ['tags' => ['array']];
        } else {
            $rules = [
                'title'   => 'required',
                'content' => 'required',
                'tags'    => 'required|array'
            ];
        }

        return $rules;
    }
}
