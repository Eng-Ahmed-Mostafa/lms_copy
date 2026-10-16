<?php

namespace App\Interface\Api\Assessments;

interface OptionInterface
{
    // crud operations
    public function getOptionById(string $id);
    public function updateOption(string $id, array $data);
    public function deleteOption(string $id);
}
