<?php

namespace App\Interface\Api\Access;

use App\Models\Device;
use App\Models\User;

interface DeviceInterface
{
    public function getUserDeviceById(string $deviceId): ?Device;

    public function createDevice(User $user, array $data): Device;

    public function getUserDevices();

    public function revokeDevice(string $deviceId): void;

    public function revokeAllUserDevices(): void;
}
