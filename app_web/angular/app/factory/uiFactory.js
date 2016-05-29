var app = angular.module('app');


app.factory('uiFactory', function () {
    var uiFactory = {};

    uiFactory.isLoading = true;
    uiFactory.panelLeft = true;


    uiFactory.dateTimePicker = {};
    uiFactory.dateTimePicker.format = ["yyyy-MM-dd HH:mm:ss", "yyyy-MM-dd", "HH:mm:ss"];
    uiFactory.dateTimePicker.options = {
        showWeeks: true
    };

    uiFactory.alert = {};
    uiFactory.alert.items = [];
    uiFactory.alert.addItem = function (alert) {
        console.log(alert);
        uiFactory.alert.items.push(alert);
    };
    uiFactory.alert.closeItem = function (index) {
        console.log(index);
        uiFactory.alert.items.splice(index, 1);
    };


    uiFactory.pagination = {};
    uiFactory.pagination.pageSize = 20;
    uiFactory.pagination.currentPage = 1;


    return uiFactory;

});