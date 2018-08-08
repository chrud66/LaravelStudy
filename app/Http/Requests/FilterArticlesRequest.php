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
        $params = config('project.params');
        $filters = implode(',', array_keys(config('project.filters.article')));

        return [
            $params['filter']   => "in:{$filters}",
            $params['limit']    => 'size:1,10',
            $params['sort']     => 'in:created_at,view_count,created',
            $params['order']    => 'in:asc,desc',
            $params['search']   => 'string',
            $params['page']     => '',
        ];
    }
}
