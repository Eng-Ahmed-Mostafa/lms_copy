<?php

namespace App\Repository\Api\Access;

use App\Interface\Api\Access\DeviceInterface;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DeviceRepository implements DeviceInterface
{

    public function getUserDeviceById(string $deviceId): ?Device
    {
        return Device::where('device_id', $deviceId)->first();
    }

    public function createDevice(User $user, array $data): Device
    {
        $device = $user->devices()->create([
            'device_id' => Str::uuid()->toString(),
            'device_name' => $data['device_name'] ?? 'Unknown Device',
            'device_type' => $data['device_type'] ?? 'Unknown Type',
            'platform' => $data['platform'] ?? 'Unknown Platform',
            'browser' => $data['browser'] ?? 'Unknown Browser',
            'ip_address' => $data['ip_address'] ?? request()->ip(),
            'user_agent' => $data['user_agent'] ?? request()->userAgent(),
            'last_used_at' => now(),
        ]);

        return $device;
    }

    public function getUserDevices()
    {
        $user = Auth::user();
        return Device::where('user_id', $user->id)->get();
    }

    public function revokeDevice(string $deviceId): void
    {
        $device = Device::where('device_id', $deviceId)->first();

        $device->update([
            'revoked_at' => now(),
        ]);
    }

    public function revokeAllUserDevices(): void
    {
        $user = Auth::user();
        Device::where('user_id', $user->id)->update([
            'revoked_at' => now(),
        ]);
    }
}
