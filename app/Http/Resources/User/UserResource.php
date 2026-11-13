<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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

            // Personal Information
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,

            // Contact Information
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,

            // Additional Information
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),

            // Account Information
            'status' => $this->status,

            // Verification Timestamps
            'email_verified_at' => $this->email_verified_at?->toDateTimeString(),
            'phone_verified_at' => $this->phone_verified_at?->toDateTimeString(),

            // Activity Timestamps
            'last_login_at' => $this->last_login_at?->toDateTimeString(),
        ];
    }
}
