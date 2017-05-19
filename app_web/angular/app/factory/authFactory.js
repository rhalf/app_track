/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Factory for authFactory. 
                            Sets and unsets credential for authFactory.
*/
var app = angular.module('app');


app.factory('authFactory', function ($cookies) {

    var authFactory = {};


    //user
    authFactory.setUser = function (user) {
        $cookies.putObject('user', user);
    };


    authFactory.getUser = function () {
        var user = $cookies.getObject('user');

        if (user) {
            return user;
        }

        return null;
    };

    //company
    authFactory.setCompany = function (company) {
        $cookies.putObject('company', company);
    };


    authFactory.getCompany = function () {
        var company = $cookies.getObject('company');

        if (company) {
            return company;
        }

        return null;
    };


    //Additional functionallity
    authFactory.clear = function () {
        $cookies.putObject('user', null);
        $cookies.putObject('company', null);
    };

    return authFactory;
});