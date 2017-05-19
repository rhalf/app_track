/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Service for sessionService. 
                            Used for check user privilege.
*/
var app = angular.module('app');


app.service('sessionService', function (authFactory) {

    this.isUserSuper = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.privilege.value == 1) ? true : false;
        } else {
            return false;
        }
    };

    this.isUserPower = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.privilege.value == 2) ? true : false;
        } else {
            return false;
        }
    };

    this.isUserTech = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.privilege.value == 3) ? true : false;
        } else {
            return false;
        }
    };

    this.isUserAdmin = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.privilege.value == 4) ? true : false;
        } else {
            return false;
        }
    };

    this.isUserWatcher = function () {
        var user = authFactory.getUser();
        if (user) {
            return (user.privilege.value == 5) ? true : false;
        } else {
            return false;
        }
    };
});