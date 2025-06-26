<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case READ_DASHBOARD = 'dashboard_read';

    case UPDATE_HOME_HERO = 'home_hero_update';

    case UPDATE_HOME_ABOUT = 'home_about_update';

    case UPDATE_HOME_OUR_SERVICE = 'home_our_service_update';

    case UPDATE_HOME_PROPOSAL = 'home_proposal_update';

    case UPDATE_HOME_EVENT = 'home_event_update';

    case UPDATE_HOME_REVIEW = 'home_review_update';

    case UPDATE_HOME_FAQ = 'home_faq_update';

    case UPDATE_HOME_CTA = 'home_cta_update';

    case UPDATE_SETTING_GENERAL = 'settings_general_update';

    case CREATE_SOCIAL_MEDIA = 'social_media_create';
    case READ_SOCIAL_MEDIA = 'social_media_read';
    case UPDATE_SOCIAL_MEDIA = 'social_media_update';
    case DELETE_SOCIAL_MEDIA = 'social_media_delete';

    case CREATE_FEATURE = 'features_create';
    case READ_FEATURE = 'features_read';
    case UPDATE_FEATURE = 'features_update';
    case DELETE_FEATURE = 'features_delete';

    case CREATE_OUR_SERVICE = 'our_service_create';
    case READ_OUR_SERVICE = 'our_service_read';
    case UPDATE_OUR_SERVICE = 'our_service_update';
    case DELETE_OUR_SERVICE = 'our_service_delete';

    case CREATE_PROPOSAL = 'proposal_create';
    case READ_PROPOSAL = 'proposal_read';
    case UPDATE_PROPOSAL = 'proposal_update';
    case DELETE_PROPOSAL = 'proposal_delete';

    case CREATE_EVENT = 'event_create';
    case READ_EVENT = 'event_read';
    case UPDATE_EVENT = 'event_update';
    case DELETE_EVENT = 'event_delete';

    case CREATE_REVIEW = 'review_create';
    case READ_REVIEW = 'review_read';
    case UPDATE_REVIEW = 'review_update';
    case DELETE_REVIEW = 'review_delete';

    case CREATE_FAQ = 'faq_create';
    case READ_FAQ = 'faq_read';
    case UPDATE_FAQ = 'faq_update';
    case DELETE_FAQ = 'faq_delete';

    case CREATE_USER = 'users_create';
    case READ_USER = 'users_read';
    case UPDATE_USER = 'users_update';
    case DELETE_USER = 'users_delete';

    case CREATE_ROLE = 'roles_create';
    case READ_ROLE = 'roles_read';
    case UPDATE_ROLE = 'roles_update';
    case DELETE_ROLE = 'roles_delete';
    case UPDATE_ROLE_PERMISSION = 'roles_update_permission';

    case CREATE_POST_CATEGORY = 'post_categories_create';
    case READ_POST_CATEGORY = 'post_categories_read';
    case UPDATE_POST_CATEGORY = 'post_categories_update';
    case DELETE_POST_CATEGORY = 'post_categories_delete';

    case CREATE_POST = 'posts_create';
    case READ_POST = 'posts_read';
    case UPDATE_POST = 'posts_update';
    case DELETE_POST = 'posts_delete';

    case READ_FILE_MANAGER = 'file_manager_read';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
