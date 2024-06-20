<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServerShadowsocksSave extends FormRequest
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
            'group_id' => 'required|array',
            'parent_id' => 'nullable|integer',
            'route_id' => 'nullable|array',
            'host' => 'required',
            'port' => 'required',
            'server_port' => 'required',
            'cipher' => 'required|in:aes-128-gcm,aes-192-gcm,aes-256-gcm,chacha20-ietf-poly1305,2022-blake3-aes-128-gcm,2022-blake3-aes-256-gcm',
            'obfs' => 'nullable|in:http',
            'obfs_settings' => 'nullable|array',
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
            'group_id.required' => 'Permission group cannot be empty',
            'group_id.array' => 'Incorrect permission group format',
            'route_id.array' => 'Incorrect routing group format',
            'parent_id.integer' => 'Incorrect parent node format',
            'host.required' => 'Node address cannot be empty',
            'port.required' => 'Connection port cannot be empty',
            'server_port.required' => 'Backend service port cannot be empty',
            'cipher.required' => 'Encryption method cannot be empty',
            'tags.array' => 'Incorrect tag format',
            'rate.required' => 'Rate cannot be empty',
            'rate.numeric' => 'Incorrect rate format',
            'obfs.in' => 'Incorrect obfuscation format',
            'obfs_settings.array' => 'Incorrect obfuscation settings format'
        ];
    }
}
