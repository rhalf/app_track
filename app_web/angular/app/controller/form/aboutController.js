﻿var app = angular.module('app');

app.controller('aboutController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    systemFactory

    ) {

    $scope.init = function () {
        $scope.system = systemFactory;
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

