<?php

namespace App\Http\Resources\Access;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'device_id' => $this->device_id,
            'user_id' => $this->user_id,
            'device_name' => $this->device_name,
            'device_type' => $this->device_type,
            'platform' => $this->platform,
            'browser' => $this->browser,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'revoked_at' => $this->revoked_at,
            'last_used_at' => $this->last_used_at,
        ];
    }
}
