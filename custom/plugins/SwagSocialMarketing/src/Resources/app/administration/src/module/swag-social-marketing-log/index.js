import './page/swag-social-marketing-log-list';
import './acl';

Shopware.Module.register('swag-social-marketing-log', {
    type: 'plugin',
    name: 'Social Marketing Log',
    title: 'swag-social-marketing-log.general.mainMenuItemGeneral',
    description: 'swag-social-marketing-log.general.descriptionTextModule',
    color: '#ff3d58',
    icon: 'default-shopping-paper-bag-product',

    routes: {
        list: {
            component: 'swag-social-marketing-log-list',
            path: 'list',
        },
    },

    navigation: [{
        label: 'swag-social-marketing-log.general.mainMenuItemGeneral',
        color: '#ff3d58',
        path: 'swag.social.marketing.log.list',
        icon: 'default-shopping-paper-bag-product',
        parent: 'sw-settings',
    }],
});
