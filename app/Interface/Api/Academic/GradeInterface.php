<?php

namespace App\Interface\Api\Academic;

interface GradeInterface
{
    // curd operations 
    public function index();
    public function store(array $data);
    public function show(string $slug);
    public function update(array $data, string $slug);
    public function destroy(string $slug);
}
