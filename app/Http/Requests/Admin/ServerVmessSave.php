<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServerVmessSave extends FormRequest
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
            'route_id' => 'nullable|array',
            'parent_id' => 'nullable|integer',
            'host' => 'required',
            'port' => 'required',
            'server_port' => 'required',
            'tls' => 'required',
            'tags' => 'nullable|array',
            'excludes' => 'nullable|array',
            'ips' => 'nullable|array',
            'rate' => 'required|numeric',
            'network' => 'required|in:tcp,kcp,ws,http,domainsocket,quic,grpc',
            'networkSettings' => 'nullable|array',
            'ruleSettings' => 'nullable|array',
            'tlsSettings' => 'nullable|array',
            'dnsSettings' => 'nullable|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Node name cannot be empty',
            'group_id.required' => 'Permission group cannot be empty',
            'group_id.array' => 'Incorrect permission group format',
            'route_id.array' => 'Incorrect route group format',
            'parent_id.integer' => 'Incorrect parent ID format',
            'host.required' => 'Node address cannot be empty',
            'port.required' => 'Connection port cannot be empty',
            'server_port.required' => 'Backend service port cannot be empty',
            'tls.required' => 'TLS cannot be empty',
            'tags.array' => 'Incorrect tag format',
            'rate.required' => 'Rate cannot be empty',
            'rate.numeric' => 'Incorrect rate format',
            'network.required' => 'Transport protocol cannot be empty',
            'network.in' => 'Incorrect transport protocol format',
            'networkSettings.array' => 'Incorrect transport protocol configuration',
            'ruleSettings.array' => 'Incorrect rule configuration',
            'tlsSettings.array' => 'Incorrect TLS configuration',
            'dnsSettings.array' => 'Incorrect DNS configuration'
        ];
    }
}
