<?php

namespace App\Interface\Api\People;

interface GuardianInterface
{
    // curd operations
    public function index();
    public function store(array $data);
    public function show(int $id);
    public function update(int $id, array $data);
    public function destroy(int $id);

    // child management
    public function getChildren(int $guardianId);
    public function addChild(int $guardianId, array $data);
    public function removeChild(int $guardianId, int $childId);
}
