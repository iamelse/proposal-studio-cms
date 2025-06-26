<?php

namespace App\Enums;

enum RoleEnum: string
{
    case MASTER = 'Master';
    case AUTHOR = 'Author';

    public function permissions(): array
    {
        return match ($this) {
            self::MASTER => [
                PermissionEnum::READ_DASHBOARD,

                PermissionEnum::UPDATE_HOME_HERO,
                PermissionEnum::UPDATE_HOME_ABOUT,
                PermissionEnum::UPDATE_HOME_OUR_SERVICE,
                PermissionEnum::UPDATE_HOME_PROPOSAL,
                PermissionEnum::UPDATE_HOME_EVENT,
                PermissionEnum::UPDATE_HOME_REVIEW,
                PermissionEnum::UPDATE_HOME_FAQ,
                PermissionEnum::UPDATE_HOME_CTA,

                PermissionEnum::UPDATE_SETTING_GENERAL,

                PermissionEnum::CREATE_SOCIAL_MEDIA,
                PermissionEnum::READ_SOCIAL_MEDIA,
                PermissionEnum::UPDATE_SOCIAL_MEDIA,
                PermissionEnum::DELETE_SOCIAL_MEDIA,

                PermissionEnum::CREATE_FEATURE,
                PermissionEnum::READ_FEATURE,
                PermissionEnum::UPDATE_FEATURE,
                PermissionEnum::DELETE_FEATURE,

                PermissionEnum::CREATE_OUR_SERVICE,
                PermissionEnum::READ_OUR_SERVICE,
                PermissionEnum::UPDATE_OUR_SERVICE,
                PermissionEnum::DELETE_OUR_SERVICE,

                PermissionEnum::CREATE_PROPOSAL,
                PermissionEnum::READ_PROPOSAL,
                PermissionEnum::UPDATE_PROPOSAL,
                PermissionEnum::DELETE_PROPOSAL,

                PermissionEnum::CREATE_EVENT,
                PermissionEnum::READ_EVENT,
                PermissionEnum::UPDATE_EVENT,
                PermissionEnum::DELETE_EVENT,

                PermissionEnum::CREATE_REVIEW,
                PermissionEnum::READ_REVIEW,
                PermissionEnum::UPDATE_REVIEW,
                PermissionEnum::DELETE_REVIEW,

                PermissionEnum::CREATE_FAQ,
                PermissionEnum::READ_FAQ,
                PermissionEnum::UPDATE_FAQ,
                PermissionEnum::DELETE_FAQ,

                PermissionEnum::CREATE_USER,
                PermissionEnum::READ_USER,
                PermissionEnum::UPDATE_USER,
                PermissionEnum::DELETE_USER,

                PermissionEnum::CREATE_ROLE,
                PermissionEnum::READ_ROLE,
                PermissionEnum::UPDATE_ROLE,
                PermissionEnum::DELETE_ROLE,

                PermissionEnum::UPDATE_ROLE_PERMISSION,

                PermissionEnum::CREATE_POST_CATEGORY,
                PermissionEnum::READ_POST_CATEGORY,
                PermissionEnum::UPDATE_POST_CATEGORY,
                PermissionEnum::DELETE_POST_CATEGORY,

                PermissionEnum::CREATE_POST,
                PermissionEnum::READ_POST,
                PermissionEnum::UPDATE_POST,
                PermissionEnum::DELETE_POST,

                PermissionEnum::READ_FILE_MANAGER
            ],
            self::AUTHOR => [
                PermissionEnum::READ_DASHBOARD,

                PermissionEnum::CREATE_POST,
                PermissionEnum::READ_POST,
                PermissionEnum::UPDATE_POST,
                PermissionEnum::DELETE_POST,

                PermissionEnum::READ_FILE_MANAGER,
            ],
        };
    }
}
