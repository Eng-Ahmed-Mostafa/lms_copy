<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserPreferencesRequest;
use App\Http\Requests\User\UserRequest;
use App\Interface\Api\User\UserInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseTrait;

    protected ?UserInterface $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    //  get all users
    public function index()
    {
        $result = $this->userService->index();
        return $this->finalResponse($result);
    }

    //  create a new user
    public function store(UserRequest $request)
    {
        $request->validated();

        $result = $this->userService->store($request->validated());

        return $this->finalResponse($result);
    }

    //  get a specific user by ID
    public function show($id)
    {
        $result = $this->userService->show($id);

        return $this->finalResponse($result);
    }

    //  update a specific user by ID
    public function update(UserRequest $request, $id)
    {
        $result = $this->userService->update($id, $request->validated());

        return $this->finalResponse($result);
    }

    //  delete a specific user by ID
    public function destroy($id)
    {
        $result = $this->userService->destroy($id);

        return $this->finalResponse($result);
    }

    //  get roles of a specific user by ID
    public function getUserRoles($id)
    {
        $result = $this->userService->getUserRoles($id);

        return $this->finalResponse($result);
    }

    //  assign roles to a specific user by ID
    public function assignRoles($id, Request $request)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $result = $this->userService->assignRoles($id, $request->input('roles'));

        return $this->finalResponse($result);
    }

    //  remove a role from a specific user by ID
    public function removeRole($id, $roleId)
    {
        $result = $this->userService->removeRole($id, $roleId);

        return $this->finalResponse($result);
    }

    //  get permissions of a specific user by ID
    public function getUserPermissions($id)
    {
        $result = $this->userService->getUserPermissions($id);

        return $this->finalResponse($result);
    }

    //  get preferences of a specific user by ID
    public function getUserPreferences($id)
    {
        $result = $this->userService->getUserPreferences($id);

        return $this->finalResponse($result);
    }

    //  update preferences of a specific user by ID
    public function updateUserPreferences($id, UserPreferencesRequest $request)
    {
        $result = $this->userService->updateUserPreferences($id, $request->validated());

        return $this->finalResponse($result);
    }

    //  upload avatar for a specific user by ID
    public function uploadAvatar($id, Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $result = $this->userService->uploadAvatar($id, $request->file('avatar'));

        return $this->finalResponse($result);
    }

    //  delete avatar for a specific user by ID
    public function deleteAvatar($id)
    {
        $result = $this->userService->deleteAvatar($id);

        return $this->finalResponse($result);
    }
}
