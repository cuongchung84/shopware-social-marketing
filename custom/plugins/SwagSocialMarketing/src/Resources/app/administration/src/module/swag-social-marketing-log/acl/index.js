Shopware.Service('privileges').addPrivilegeMappingEntry({
    category: 'permissions',
    parent: 'settings',
    key: 'swag_social_marketing_log',
    roles: {
        viewer: {
            privileges: [
                'swag_social_marketing_log:read',
            ],
        },
        editor: {
            privileges: [
                'swag_social_marketing_log:read',
                'swag_social_marketing_log:update',
            ],
        },
        creator: {
            privileges: [
                'swag_social_marketing_log:read',
                'swag_social_marketing_log:update',
                'swag_social_marketing_log:create',
            ],
        },
        deleter: {
            privileges: [
                'swag_social_marketing_log:read',
                'swag_social_marketing_log:update',
                'swag_social_marketing_log:create',
                'swag_social_marketing_log:delete',
            ],
        },
    },
});
