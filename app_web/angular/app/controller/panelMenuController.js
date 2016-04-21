﻿var app = angular.module('app');


app.controller('panelMenuController', function ($scope, $location, $uibModal, panelLeftFactory, authFactory) {

    $scope.user = authFactory.getAccessToken();


    $scope.setToggle = function () {
        panelLeftFactory.toggle = !panelLeftFactory.toggle;
    };

    $scope.logout = function () {
        authFactory.setAccessToken(null);
        $location.path('/')
    };


    $scope.showCompany = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/template/class/company.html',
            controller: 'companyController'
        });
    };

});
