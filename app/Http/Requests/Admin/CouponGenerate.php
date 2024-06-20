<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponGenerate extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'generate_count' => 'nullable|integer|max:500',
            'name' => 'required',
            'type' => 'required|in:1,2',
            'value' => 'required|integer',
            'started_at' => 'required|integer',
            'ended_at' => 'required|integer',
            'limit_use' => 'nullable|integer',
            'limit_use_with_user' => 'nullable|integer',
            'limit_plan_ids' => 'nullable|array',
            'limit_period' => 'nullable|array',
            'code' => ''
        ];
    }

    public function messages()
    {
        return [
            'generate_count.integer' => 'The number of generations must be a number',
            'generate_count.max' => 'The maximum number of generations is 500',
            'name.required' => 'Name cannot be empty',
            'type.required' => 'Type cannot be empty',
            'type.in' => 'Incorrect type format',
            'value.required' => 'Amount or percentage cannot be empty',
            'value.integer' => 'Incorrect amount or percentage format',
            'started_at.required' => 'Start time cannot be empty',
            'started_at.integer' => 'Incorrect start time format',
            'ended_at.required' => 'End time cannot be empty',
            'ended_at.integer' => 'Incorrect end time format',
            'limit_use.integer' => 'Incorrect format for maximum number of uses',
            'limit_use_with_user.integer' => 'Incorrect format for limiting the number of uses per user',
            'limit_plan_ids.array' => 'Incorrect format for specifying subscriptions',
            'limit_period.array' => 'Incorrect format for specifying periods'
        ];
    }
}
