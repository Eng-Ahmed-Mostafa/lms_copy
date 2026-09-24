<?php

namespace App\Interface\Api\People;

interface StudentInterface
{
    // curd operations
    public function index();
    public function store(array $data);
    public function show(int $id);
    public function update(int $id, array $data);
    public function destroy(int $id);

    // relationship operations
    public function getTeachers(int $id);
}
