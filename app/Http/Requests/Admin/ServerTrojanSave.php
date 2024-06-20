<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServerTrojanSave extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'show' => '',
            'name' => 'required',
            'network' => 'required',
            'networkSettings' => 'nullable',
            'group_id' => 'required|array',
            'route_id' => 'nullable|array',
            'parent_id' => 'nullable|integer',
            'host' => 'required',
            'port' => 'required',
            'server_port' => 'required',
            'allow_insecure' => 'nullable|in:0,1',
            'server_name' => 'nullable',
            'tags' => 'nullable|array',
            'excludes' => 'nullable|array',
            'ips' => 'nullable|array',
            'rate' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Node name cannot be empty',
            'network.required' => 'Transport protocol cannot be empty',
            'group_id.required' => 'Permission group cannot be empty',
            'group_id.array' => 'Incorrect permission group format',
            'route_id.array' => 'Incorrect route group format',
            'parent_id.integer' => 'Incorrect parent node format',
            'host.required' => 'Node address cannot be empty',
            'port.required' => 'Connection port cannot be empty',
            'server_port.required' => 'Backend service port cannot be empty',
            'allow_insecure.in' => 'Incorrect format for Allow Insecure',
            'tags.array' => 'Incorrect tag format',
            'rate.required' => 'Rate cannot be empty',
            'rate.numeric' => 'Incorrect rate format'
        ];
    }
}
