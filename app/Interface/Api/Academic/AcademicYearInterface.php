<?php

namespace App\Interface\Api\Academic;

interface AcademicYearInterface
{
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function update(string $id, array $data);
    public function destroy(string $id);

    public function activate(string $id);
    public function deactivate(string $id);

    public function getCurrentAcademicYear();
}
