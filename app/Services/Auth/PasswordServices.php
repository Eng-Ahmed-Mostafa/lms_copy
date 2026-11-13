<?php

namespace App\Services\Auth;

use App\Interface\Api\Auth\PasswordInterface;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Password;

class PasswordServices
{
    use RepositoryTrait;
    public function __construct(
        protected readonly PasswordInterface $password,
    ) {}

    public function forgetPassword(string $email): array
    {
        $status = $this->password->sendResetLink($email);

        if ($status === Password::RESET_LINK_SENT) {
            return $this->returnData(true, 'Password reset link sent successfully.', 200);
        }
        return $this->returnData(false, 'Failed to send password reset link.', 400);
    }

    public function resetPassword(array $data): array
    {
        $status = $this->password->resetPassword($data);

        if ($status === Password::PASSWORD_RESET) {
            return $this->returnData(true, 'Password reset successfully.', 200);
        }

        return $this->returnData(false, 'Failed to reset password.', 400);
    }

    public function checkPassword(string $password, string $hashedPassword): bool
    {
        return $this->password->checkPassword($password, $hashedPassword);
    }
}
