var app = angular.module('app');


app.factory('uiFactory', function () {
    var uiFactory = {};

    uiFactory.isLoading = true;

    uiFactory.panelLeft = false;
    uiFactory.panelMenuMobile = false;
    uiFactory.panelSystem = false;
    uiFactory.panelSystemTemplate = null;

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
    uiFactory.pagination.options = [];
    uiFactory.pagination.options = [{ "Value": 2}, {"Value": 10}, {"Value": 20}, {"Value": 30}, {"Value": 50 }];

    return uiFactory;

});