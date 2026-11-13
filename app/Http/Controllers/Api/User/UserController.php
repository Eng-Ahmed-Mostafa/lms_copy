<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserPreferencesRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\User\UserServices;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly UserServices $userService) {}

    //  get all users
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $result = $this->userService->getAllUsers();
        return $this->finalResponse($result, UserResource::collection($result['data']));
    }

    //  create a new user
    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);
        $result = $this->userService->createUser($request->validated());
        return $this->finalResponse($result, new UserResource($result['data']));
    }

    //  get a specific user by ID
    public function show($id)
    {
        $this->authorize('view', User::class);
        $result = $this->userService->getUserById($id);

        return $this->finalResponse($result, new UserResource($result['data']));
    }

    //  update a specific user by ID
    public function update(UserRequest $request, $id)
    {
        $this->authorize('update', User::class);
        $result = $this->userService->updateUser($id, $request->validated());

        return $this->finalResponse($result, new UserResource($result['data']));
    }

    //  delete a specific user by ID
    public function destroy(string $id)
    {
        $this->authorize('delete', User::class);
        $result = $this->userService->deleteUser($id);

        return $this->finalResponse($result);
    }

    //  get preferences of a specific user by ID
    public function getUserPreferences(User $user)
    {
        $this->authorize('showPreferences', $user);
        $result = $this->userService->getUserPreferences($user->id);

        return $this->finalResponse($result);
    }

    //  update preferences of a specific user by ID
    public function updateUserPreferences(User $user, UserPreferencesRequest $request)
    {
        $this->authorize('updatePreferences', $user);
        $result = $this->userService->updateUserPreferences($user->id, $request->validated());

        return $this->finalResponse($result);
    }

    //  upload avatar for a specific user by ID
    public function uploadAvatar(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $result = $this->userService->uploadUserAvatar($user->id, $request->file('avatar'));

        return $this->finalResponse($result);
    }

    //  delete avatar for a specific user by ID
    public function deleteAvatar(User $user)
    {
        $this->authorize('update', $user);
        $result = $this->userService->deleteUserAvatar($user->id);
        return $this->finalResponse($result);
    }

    // get user details for the authenticated user
    public function getMeDetails(Request $request)
    {
        $this->authorize('viewMe', User::class);
        $result = $this->userService->getMeDetails($request);
        return $this->finalResponse($result);
    }
}
