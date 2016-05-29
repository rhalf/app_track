﻿var app = angular.module('app');

app.filter('privilegeFilter', function ($filter, flagFactory) {
    return function (value, option) {
        var result = "UNKNOWN";
        angular.forEach(flagFactory.Privilege, function (object) {
            if (object.Value === value) {
                switch (option) {
                    case 'name':
                        result = object.Name;
                        break;
                    case 'desc':
                        result = object.Desc;
                        break;
                    default:
                        result = object.Name;
                }
            }
        });
        return result;
    }
});