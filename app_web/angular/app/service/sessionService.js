var app = angular.module('app');


app.service('sessionService', function (authFactory) {

    this.isUserSuper = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.Privilege.Value == 1) ? true : false;
        } else {
            return false;
        }
    };

    this.isUserPower = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.Privilege.Value == 2) ? true : false;
        } else {
            return false;
        }
    };

    this.isUserTech = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.Privilege.Value == 3) ? true : false;
        } else {
            return false;
        }
    };

    this.isUserAdmin = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.Privilege.Value == 4) ? true : false;
        } else {
            return false;
        }
    };

    this.isUserWatcher = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.Privilege.Value == 5) ? true : false;
        } else {
            return false;
        }
    };

    this.isUserDemo = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.Privilege.Value == 6) ? true : false;
        } else {
            return false;
        }
    };
});