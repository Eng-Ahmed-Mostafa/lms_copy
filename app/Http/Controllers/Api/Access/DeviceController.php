<?php

namespace App\Http\Controllers\Api\Access;

use App\Http\Controllers\Controller;
use App\Http\Resources\Access\DeviceResource;
use App\Services\Access\DeviceServices;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function __construct(
        protected readonly DeviceServices $deviceServices
    ) {}

    //  get all devices for the authenticated user
    public function index()
    {
        $devices = $this->deviceServices->getUserDevices();

        if (!$devices) {
            return response()->json([
                'message' => 'No devices found for the user',
            ], 404);
        }

        return DeviceResource::collection($devices);
    }

    //  revoke a specific device for the authenticated user
    public function destroy(string $deviceId)
    {
        $this->deviceServices->revokeDevice($deviceId);

        return response()->json([
            'message' => 'Device revoked successfully',
        ], 200);
    }

    //  revoke all devices for the authenticated user
    public function destroyAll()
    {
        $this->deviceServices->revokeAllUserDevices();

        return response()->json([
            'message' => 'All devices revoked successfully',
        ], 200);
    }
}
