define([
    'uiComponent',
    'ko'
], function (Component, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'KOVendor_KnockoutDemo/hello'
        },

        firstName: ko.observable('Bert'),
        lastName: ko.observable('Bertington'),

        initialize: function () {
            this._super();

            this.fullName = ko.computed(function () {
                return this.firstName() + ' ' + this.lastName();
            }, this);

            return this;
        },

        capitalizeLastName: function () {
            this.lastName(this.lastName().toUpperCase());
        }
    });
});