<?php

namespace App\Constants;

class PermissionsConstants
{
    public const SUPERADMIN_GROUP = [
        'admin.*',
        'users.*',
        'forms.*',
        'missions.*',
        'societies.*',
        'industries.*',
        'profile.*',
        'completed-forms.*'
    ];

    public const ADMIN_GROUP = [
        'users.*',
        'forms.*',
        'missions.*',
        'societies.*',
        'industries.*',
        'profile.*',
        'completed-forms.*'
    ];

    public const BASIC_GROUP = [
        'profile.*',
        'forms.read',
        'completed-forms.read',
        'missions.read'
    ];

    public static function getConstants(): array
    {
        return [
            'SUPERADMIN_GROUP' => self::SUPERADMIN_GROUP,
            'ADMIN_GROUP' => self::ADMIN_GROUP,
            'BASIC_GROUP' => self::BASIC_GROUP,
        ];
    }
}