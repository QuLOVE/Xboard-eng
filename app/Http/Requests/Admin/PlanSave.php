<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlanSave extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'content' => '',
            'group_id' => 'required',
            'transfer_enable' => 'required',
            'month_price' => 'nullable|integer',
            'quarter_price' => 'nullable|integer',
            'half_year_price' => 'nullable|integer',
            'year_price' => 'nullable|integer',
            'two_year_price' => 'nullable|integer',
            'three_year_price' => 'nullable|integer',
            'onetime_price' => 'nullable|integer',
            'reset_price' => 'nullable|integer',
            'reset_traffic_method' => 'nullable|integer|in:0,1,2,3,4',
            'capacity_limit' => 'nullable|integer',
            'speed_limit' => 'nullable|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Plan name cannot be empty',
            'type.required' => 'Plan type cannot be empty',
            'type.in' => 'Incorrect plan type format',
            'group_id.required' => 'Permission group cannot be empty',
            'transfer_enable.required' => 'Traffic cannot be empty',
            'month_price.integer' => 'Incorrect monthly payment amount format',
            'quarter_price.integer' => 'Incorrect quarterly payment amount format',
            'half_year_price.integer' => 'Incorrect half-year payment amount format',
            'year_price.integer' => 'Incorrect annual payment amount format',
            'two_year_price.integer' => 'Incorrect two-year payment amount format',
            'three_year_price.integer' => 'Incorrect three-year payment amount format',
            'onetime_price.integer' => 'Incorrect one-time payment amount format',
            'reset_price.integer' => 'Incorrect traffic reset package amount format',
            'reset_traffic_method.integer' => 'Incorrect traffic reset method format',
            'reset_traffic_method.in' => 'Incorrect traffic reset method format',
            'capacity_limit.integer' => 'Incorrect user capacity limit format',
            'speed_limit.integer' => 'Incorrect speed limit format'
        ];
    }
}
