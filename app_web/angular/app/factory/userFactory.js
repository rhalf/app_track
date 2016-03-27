var app = angular.module('app');


app.factory('userFactory', function () {
    var user = {};

    user.setLocal = function () {
        // Save data to sessionStorage
        sessionStorage.setItem('user', 'value');
    };

    user.getLocal = function () {
        // Save data to sessionStorage
        usersessionStorage.getItem();
    };
    user.setSession = function () {

    };
    user.getSession = function () {
        // Save data to sessionStorage
        sessionStorage.setItem('user', 'value');
    };
    return alert;
});