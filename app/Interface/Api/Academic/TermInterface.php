<?php

namespace App\Interface\Api\Academic;

interface TermInterface
{
    //? curd operations for terms
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function update(array $data, string $id);
    public function destroy(string $id);

    //? activate and deactivate terms
    public function activate(string $id);
    public function deactivate(string $id);
}
