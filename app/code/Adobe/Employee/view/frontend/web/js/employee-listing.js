/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'ko',
    'uiComponent',
    'jquery',
    'mage/url'
], function (ko, Component, $, urlBuilder) {
    'use strict';

    return Component.extend({

        defaults: {
            template: 'Adobe_Employee/employee-listing'
        },

        /**
         * Initialize component
         */
        initialize: function () {
            this._super();
            this.initObservables();
            this.loadEmployees();
        },

        /**
         * Initialize observables
         */
        initObservables: function () {
            this.employees      = ko.observableArray([]);
            this.isLoading      = ko.observable(true);
            this.errorMessage   = ko.observable('');
            this.successMessage = ko.observable('');

            this.showForm    = ko.observable(false);
            this.isEditMode  = ko.observable(false);
            this.currentId   = ko.observable(null);
            this.name        = ko.observable('');
            this.gender      = ko.observable('');
            this.designation = ko.observable('');
            this.joiningDate = ko.observable('');
            this.address     = ko.observable('');
            this.status      = ko.observable(1);
            this.hobbies     = ko.observable('');

            this.hobbiesOptions = [
                { value: 'Reading',     label: 'Reading' },
                { value: 'Travelling',  label: 'Travelling' },
                { value: 'Music',       label: 'Music' },
                { value: 'Sports',      label: 'Sports' }
            ];

            this.selectedHobbies = ko.observableArray([]);

            return this;
        },

        /**
         * Get API base URL
         *
         * @param {string} path
         * @returns {string}
         */
        getApiUrl: function (path) {
            return urlBuilder.build(
                'rest/V1/employees' + (path || '')
            );
        },

        /**
         * Load all employees via AJAX
         */
        loadEmployees: function () {
            var self = this;
            self.isLoading(true);
            self.errorMessage('');

            $.ajax({
                url: self.getApiUrl(),
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    self.employees(response);
                    self.isLoading(false);
                },
                error: function () {
                    self.errorMessage('Failed to load employees.');
                    self.isLoading(false);
                }
            });
        },

        /**
         * Show add new employee form
         */
        showAddForm: function () {
            this.resetForm();
            this.isEditMode(false);
            this.showForm(true);
        },

        /**
         * Show edit employee form
         *
         * @param {Object} employee
         */
        showEditForm: function (employee) {
            this.resetForm();
            this.isEditMode(true);
            this.currentId(employee.id);
            this.name(employee.name);
            this.gender(employee.gender);
            this.designation(employee.designation);
            this.joiningDate(employee.joining_date);
            this.address(employee.address);
            this.status(employee.status);

            // Get valid hobby values from hobbiesOptions
            var validHobbies = this.hobbiesOptions.map(
                function (h) { return h.value; }
            );

            var hobbiesArray = employee.hobbies
                ? employee.hobbies.split(',').map(
                    function (h) {
                        var trimmed = h.trim();

                        var matched = validHobbies.find(
                            function(v) {
                                return v.toLowerCase() ===
                                    trimmed.toLowerCase();
                            }
                        );
                        return matched || trimmed;
                    }
                )
                : [];
            hobbiesArray = hobbiesArray.filter(
                function(value, index, self) {
                    return self.indexOf(value) === index;
                }
            );
            this.selectedHobbies(hobbiesArray);
            this.hobbies(hobbiesArray.join(','));
            this.showForm(true);
        },

        /**
         * Handle hobby checkbox change event
         *
         * @param {Object} data
         * @param {Event} event
         */
        onHobbyChange: function (data, event) {
            var self     = this;
            var value    = event.target.value;
            var checked  = event.target.checked;
            var selected = self.selectedHobbies().slice();
            var index    = selected.indexOf(value);

            if (checked && index === -1) {
                selected.push(value);
            } else if (!checked && index !== -1) {
                selected.splice(index, 1);
            }

            self.selectedHobbies(selected);
            self.hobbies(selected.join(','));
        },

        /**
         * Reset form fields
         */
        resetForm: function () {
            this.currentId(null);
            this.name('');
            this.gender('');
            this.designation('');
            this.joiningDate('');
            this.address('');
            this.status(1);
            this.hobbies('');
            this.selectedHobbies([]);
            this.errorMessage('');
            this.successMessage('');
        },

        /**
         * Cancel form
         */
        cancelForm: function () {
            this.showForm(false);
            this.resetForm();
        },

        /**
         * Save employee create or update
         */
        saveEmployee: function () {
            var self = this;

            // Get unique hobbies only
            var uniqueHobbies = self.selectedHobbies().filter(
                function (value, index, arr) {
                   return arr.indexOf(value) === index;
                }
            ); 
            var employeePayload = {
                name:         self.name(),
                gender:       self.gender(),
                designation:  self.designation(),
                joining_date: self.joiningDate(),
                address:      self.address(),
                status:       parseInt(self.status()),
                hobbies:      uniqueHobbies.join(',')
            };

            var url    = self.getApiUrl();
            var method = 'POST';

            if (self.isEditMode() && self.currentId()) {
                url    = self.getApiUrl('/' + self.currentId());
                method = 'PUT';
            }

            var requestData = {
                employee: employeePayload
            };

            $.ajax({
                url: url,
                type: method,
                contentType: 'application/json',
                data: JSON.stringify(requestData),
                success: function () {
                    self.successMessage(
                        self.isEditMode()
                            ? 'Employee updated successfully.'
                            : 'Employee added successfully.'
                    );
                    self.showForm(false);
                    self.resetForm();
                    self.loadEmployees();
                },
                error: function (xhr) {
                    var errorMsg = 'Failed to save employee.';
                    try {
                        var resp = JSON.parse(xhr.responseText);
                        if (resp.message) {
                            errorMsg = resp.message;
                        }
                    } catch (e) {}
                    self.errorMessage(errorMsg);
                }
            });
        },

        /**
         * Delete employee
         *
         * @param {Object} employee
         */
        deleteEmployee: function (employee) {
            var self = this;

            if (!confirm(
                'Are you sure you want to delete ' +
                employee.name + '?'
            )) {
                return;
            }

            $.ajax({
                url: self.getApiUrl('/' + employee.id),
                type: 'DELETE',
                success: function () {
                    self.successMessage(
                        'Employee deleted successfully.'
                    );
                    self.loadEmployees();
                },
                error: function (xhr) {
                    var errorMsg = 'Failed to delete employee.';
                    try {
                        var resp = JSON.parse(xhr.responseText);
                        if (resp.message) {
                            errorMsg = resp.message;
                        }
                    } catch (e) {}
                    self.errorMessage(errorMsg);
                }
            });
        },

        /**
         * Get status label
         *
         * @param {number} status
         * @returns {string}
         */
        getStatusLabel: function (status) {
            return parseInt(status) === 1
                ? 'Active'
                : 'Inactive';
        }
    });
});