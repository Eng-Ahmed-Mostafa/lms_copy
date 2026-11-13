<?php

namespace App\Interface\Api\Auth;

interface PasswordInterface
{
    public function sendResetLink(string $email);

    public function resetPassword(array $data);

    public function checkPassword(string $password, string $hashedPassword): bool;

}
