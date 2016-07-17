var app = angular.module('app');


app.factory('authFactory', function ($cookies) {

    var authFactory = {};


    //user
    authFactory.setUser = function (user) {
        authFactory.user = user;
    };


    authFactory.getUser = function () {
        var authFactory = $cookies.getObject('authFactory');

        if (authFactory) {
            if (authFactory.user) {
                return authFactory.user;
            }
        }
        return null;
    };

    //company
    authFactory.setCompany = function (company) {
        authFactory.company = company;
    };


    authFactory.getCompany = function () {
        var authFactory = $cookies.getObject('authFactory');

        if (authFactory) {
            if (authFactory.company) {
                return authFactory.company;
            }
        }
        return null;
    };


    //Additional functionallity
    authFactory.save = function () {
        $cookies.putObject('authFactory', authFactory);
    };

    authFactory.remove = function () {
        $cookies.putObject('authFactory', null);
    };

    return authFactory;
});                                                                                                                                                                                                                                         