define([
    'uiComponent',
    'ko',
    'jquery',
    'mage/url',
    'Magento_Ui/js/modal/confirm'
], function (Component, ko, $, urlBuilder, confirmation) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Adobe_Employee/employee-listing'
        },

        initialize: function () {
            this._super();

            this.employees = ko.observableArray([]);
            this.showForm = ko.observable(false);

            this.currentPage = ko.observable(1);
            this.lastPage = ko.observable(1);

            this.id = ko.observable('');
            this.name = ko.observable('');
            this.gender = ko.observable('Male');
            this.joiningDate = ko.observable('');
            this.designation = ko.observable('');
            this.address = ko.observable('');
            this.status = ko.observable('1');
            this.hobbies = ko.observableArray([]);

            this.allHobbies = [
                'Reading',
                'Sports',
                'Music',
                'Travelling'
            ];

            this.loadEmployees();

            return this;
        },

        loadEmployees: function () {
            var self = this;

            $.ajax({
                url: urlBuilder.build('employee/ajax/listing?page=' + self.currentPage()),
                type: 'GET',
                dataType: 'json'
            }).done(function (response) {

                self.employees(response.items || []);
                self.currentPage(parseInt(response.current_page || 1));
                self.lastPage(parseInt(response.last_page || 1));

            });
        },

        addEmployee: function () {
            this.resetForm();
            this.showForm(true);
        },

        editEmployee: function (emp) {
            this.id(emp.entity_id);
            this.name(emp.name);
            this.gender(emp.gender);
            this.joiningDate(emp.joining_date);
            this.designation(emp.designation);
            this.address(emp.address);
            this.status(emp.status);
            this.hobbies(emp.hobbies ? emp.hobbies.split(',') : []);
            this.showForm(true);
        },

        saveEmployee: function () {
            var self = this;

            $.ajax({
                url: urlBuilder.build('employee/ajax/save'),
                type: 'POST',
                dataType: 'json',
                data: {
                    id: self.id(),
                    name: self.name(),
                    gender: self.gender(),
                    joining_date: self.joiningDate(),
                    designation: self.designation(),
                    address: self.address(),
                    status: self.status(),
                    hobbies: self.hobbies().join(',')
                }
            }).done(function () {
                self.showForm(false);
                self.resetForm();
                self.currentPage(1);
                self.loadEmployees();
            });
        },

        deleteEmployee: function (emp) {
            var self = this;

            confirmation({
                title: 'Delete',
                content: 'Are you sure?',
                actions: {
                    confirm: function () {
                        $.ajax({
                            url: urlBuilder.build('employee/ajax/delete'),
                            type: 'POST',
                            data: { id: emp.entity_id }
                        }).done(function () {
                            self.loadEmployees();
                        });
                    }
                }
            });
        },

        previousPage: function () {
            if (this.currentPage() > 1) {
                this.currentPage(this.currentPage() - 1);
                this.loadEmployees();
            }
        },

        nextPage: function () {
            if (this.currentPage() < this.lastPage()) {
                this.currentPage(this.currentPage() + 1);
                this.loadEmployees();
            }
        },

        cancelForm: function () {
            this.showForm(false);
        },

        resetForm: function () {
            this.id('');
            this.name('');
            this.gender('Male');
            this.joiningDate('');
            this.designation('');
            this.address('');
            this.status('1');
            this.hobbies([]);
        }
    });
});