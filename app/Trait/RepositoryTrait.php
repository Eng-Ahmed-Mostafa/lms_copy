<?php

namespace App\Trait;

trait RepositoryTrait
{
    public function returnData(bool $success, string $message, int $code = 200, $data = null) {
        return [
            "success" => $success,
            "message" => $message,
            "code" => $code,
            "data" => $data
        ];
    }
}
