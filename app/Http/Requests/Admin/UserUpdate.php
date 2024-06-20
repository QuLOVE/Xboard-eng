<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email:strict',
            'password' => 'nullable|min:8',
            'transfer_enable' => 'numeric',
            'expired_at' => 'nullable|integer',
            'banned' => 'required|in:0,1',
            'plan_id' => 'nullable|integer',
            'commission_rate' => 'nullable|integer|min:0|max:100',
            'discount' => 'nullable|integer|min:0|max:100',
            'is_admin' => 'required|in:0,1',
            'is_staff' => 'required|in:0,1',
            'u' => 'integer',
            'd' => 'integer',
            'balance' => 'integer',
            'commission_type' => 'integer',
            'commission_balance' => 'integer',
            'remarks' => 'nullable',
            'speed_limit' => 'nullable|integer'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email cannot be empty',
            'email.email' => 'Incorrect email format',
            'transfer_enable.numeric' => 'Incorrect traffic format',
            'expired_at.integer' => 'Incorrect expiration time format',
            'banned.required' => 'Whether to ban cannot be empty',
            'banned.in' => 'Incorrect format for whether to ban',
            'is_admin.required' => 'Whether to be an administrator cannot be empty',
            'is_admin.in' => 'Incorrect format for whether to be an administrator',
            'is_staff.required' => 'Whether to be staff cannot be empty',
            'is_staff.in' => 'Incorrect format for whether to be staff',
            'plan_id.integer' => 'Incorrect subscription plan format',
            'commission_rate.integer' => 'Incorrect referral bonus ratio format',
            'commission_rate.nullable' => 'Incorrect referral bonus ratio format',
            'commission_rate.min' => 'The minimum referral bonus ratio is 0',
            'commission_rate.max' => 'The maximum referral bonus ratio is 100',
            'discount.integer' => 'Incorrect exclusive discount ratio format',
            'discount.nullable' => 'Incorrect exclusive discount ratio format',
            'discount.min' => 'The minimum exclusive discount ratio is 0',
            'discount.max' => 'The maximum exclusive discount ratio is 100',
            'u.integer' => 'Incorrect upstream traffic format',
            'd.integer' => 'Incorrect downstream traffic format',
            'balance.integer' => 'Incorrect balance format',
            'commission_balance.integer' => 'Incorrect commission format',
            'password.min' => 'The password length is at least 8 characters',
            'speed_limit.integer' => 'Incorrect speed limit format'
        ];
    }
}
