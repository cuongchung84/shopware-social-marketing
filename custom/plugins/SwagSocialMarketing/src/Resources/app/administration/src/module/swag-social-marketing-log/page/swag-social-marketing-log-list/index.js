import template from './swag-social-marketing-log-list.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('swag-social-marketing-log-list', {
    template,

    inject: ['repositoryFactory'],

    mixins: [
        Mixin.getByName('listing'),
    ],

    data() {
        return {
            logs: null,
            isLoading: false,
            sortBy: 'createdAt',
            sortDirection: 'DESC',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(),
        };
    },

    computed: {
        logRepository() {
            return this.repositoryFactory.create('swag_social_marketing_log');
        },
    },

    methods: {
        getList() {
            this.isLoading = true;
            const criteria = new Criteria(this.page, this.limit);
            criteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection));

            this.logRepository.search(criteria, Shopware.Context.api).then((result) => {
                this.logs = result;
                this.isLoading = false;
            });
        },

        getColumns() {
            return [{
                property: 'productId',
                label: 'Product ID',
                routerLink: 'sw.product.detail',
            }, {
                property: 'network',
                label: 'Network',
            }, {
                property: 'status',
                label: 'Status',
            }, {
                property: 'message',
                label: 'Message',
            }, {
                property: 'createdAt',
                label: 'Date',
            }];
        },
    },
});
