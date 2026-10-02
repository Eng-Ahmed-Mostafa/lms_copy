<?php

namespace App\Enum;

enum EnrollmentSource: string
{
    case SELF = 'self';
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case IMPORT = 'import';
    case FREE = 'free';
    case PAYMENT = 'payment';
    case COUPON = 'coupon';
}
