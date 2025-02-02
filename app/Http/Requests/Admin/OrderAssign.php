<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrderAssign extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'plan_id' => 'required',
            'email' => 'required',
            'total_amount' => 'required',
            'period' => 'required|in:month_price,quarter_price,half_year_price,year_price,two_year_price,three_year_price,onetime_price,reset_price'
        ];
    }

    public function messages()
    {
        return [
            'plan_id.required' => 'Subscription cannot be empty',
            'email.required' => 'Mailbox cannot be empty',
            'total_amount.required' => 'Payment amount cannot be empty',
            'period.required' => 'The subscription period cant be empty',
            'period.in' => 'Incorrect subscription period format'
        ];
    }
}
