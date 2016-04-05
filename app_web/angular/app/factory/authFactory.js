﻿var app = angular.module('app');


app.factory('authFactory', function ($cookies) {

    var authFactory = {};

    authFactory.setAccessToken = function (token) {
        authFactory.token = token;
        $cookies.putObject('authFactory', authFactory);
    };

    authFactory.getAccessToken = function () {
        var authFactory =  $cookies.getObject('authFactory');
        return authFactory.token;
    };

    return authFactory;
});