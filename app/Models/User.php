<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\Auth\ForgetPasswordNotification;
use App\Notifications\Auth\LoginFromDeviceNotification;
use App\Notifications\Auth\VerifyEmailNotification;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(
    [
    'first_name',
    'last_name',
    'email',
    'phone',
    'password',
    'avatar',
    'gender',
    'date_of_birth',
    'status',
    'last_login_at',
    ]
)]

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function ($user) {

            $user->preferences()->create();

        });
    }

    /**
     * Send Notifications
     */

    // send the password reset notification.
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ForgetPasswordNotification($token));
    }

    // send the email verification notification.
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    // send the login from device notification.
    public function sendLoginFromDeviceNotification($deviceId)
    {
        $this->notify(new LoginFromDeviceNotification($deviceId));
    }

    /**
     * Relationships
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempts::class);
    }

    public function preferences()
    {
        return $this->hasOne(UserPreferences::class);
    }
}
