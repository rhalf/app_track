var app = angular.module('app');


app.factory('uiFactory', function () {
    var uiFactory = {};

    uiFactory.isLoading = true;
    uiFactory.panelLeft = true;
    uiFactory.panelAdmin = false;

    uiFactory.panelAdminTemplate = 'app/view/form/system/companies.html';


    uiFactory.dateTimePicker = {};
    uiFactory.dateTimePicker.format = ["yyyy-MM-dd HH:mm:ss", "yyyy-MM-dd", "HH:mm:ss"];
    uiFactory.dateTimePicker.options = {
        showWeeks: true
    };

    uiFactory.alert = {};
    uiFactory.alert.items = [];
    uiFactory.alert.timeout = 2500;
    uiFactory.alert.addItem = function (alert) {
        uiFactory.alert.items.push(alert);
    };
    uiFactory.alert.closeItem = function (index) {
        uiFactory.alert.items.splice(index, 1);
    };


    uiFactory.pagination = {};
    uiFactory.pagination.pageSize1 = 10;
    uiFactory.pagination.pageSize2 = 20;

    uiFactory.pagination.currentPage = 1;


    return uiFactory;

});