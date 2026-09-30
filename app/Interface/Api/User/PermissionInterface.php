<?php

namespace App\Interface\Api\User;

interface PermissionInterface
{
    // CRUD Operations
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function update(string $id, array $data);
    public function destroy(string $id);
}
