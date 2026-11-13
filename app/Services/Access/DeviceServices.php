<?php

namespace App\Services\Access;

use App\Interface\Api\Access\DeviceInterface;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Ruvelo\Device\Device;

class DeviceServices
{
    public function __construct(
        protected readonly DeviceInterface $device
    ) {}

    public function getUserDeviceById(string $deviceId)
    {
        return $this->device->getUserDeviceById($deviceId);
    }

    public function createDevice(User $user, array $data)
    {
        return $this->device->createDevice($user, $data);
    }

    public function getUserDevices()
    {
        return $this->device->getUserDevices();
    }

    public function revokeDevice(string $deviceId): void
    {
        $device = $this->device->getUserDeviceById($deviceId);

        if (!$device) {
            throw ValidationException::withMessages([
                'device_id' => ['The specified device does not exist.'],
            ]);
        }

        $device->personalAccessTokens()->delete();
        $this->device->revokeDevice($deviceId);
    }

    public function revokeAllUserDevices(): void
    {
        $this->device->revokeAllUserDevices();
    }

    public function getDeviceDataFromDevice(Device $device, ?string $ipAddress = null): array {
        $deviceName = trim(implode(' ', array_filter([
            $device->brand,
            $device->model,
        ])));

        return [
            'device_name' => $deviceName ?: 'Unknown Device',
            'device_type' => $device->type->value,
            'platform' => (string) $device->os ?: 'Unknown Platform',
            'browser' => $device->browser->name ?? 'Unknown Browser',
            'ip_address' => $ipAddress,
            'user_agent' => $device->userAgent,
        ];
    }
}
