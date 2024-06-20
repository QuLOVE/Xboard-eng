<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserFetch extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filter.*.key' => 'required|in:id,email,transfer_enable,d,expired_at,uuid,token,invite_by_email,invite_user_id,plan_id,banned,remarks,is_admin',
            'filter.*.condition' => 'required|in:>,<,=,>=,<=,fuzzy,!=',
            'filter.*.value' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'filter.*.key.required' => 'Filter key cannot be empty',
            'filter.*.key.in' => 'Incorrect filter key parameter',
            'filter.*.condition.required' => 'Filter condition cannot be empty',
            'filter.*.condition.in' => 'Incorrect filter condition parameter',
            'filter.*.value.required' => 'Filter value cannot be empty'
        ];
    }
}
