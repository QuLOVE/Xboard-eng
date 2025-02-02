<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KnowledgeSort extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'knowledge_ids' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'knowledge_ids.required' => 'Knowledge ID cannot be null',
            'knowledge_ids.array' => 'Knowledge ID format is incorrect'
        ];
    }
}
