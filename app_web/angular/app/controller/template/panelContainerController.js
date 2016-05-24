var app = angular.module('app');

app.controller('panelContainerController', function (
    $scope,
    uiFactory
    ) {

    $scope.init = function () {
        $scope.alert = uiFactory.alert;
    }

    $scope.closeAlert = function (index) {
        $scope.alert.closeAlert(index);
    }

    $scope.getToggle = function () {
        return uiFactory.panelLeft;
    };

    $scope.isLoading = function () {
        return uiFactory.isLoading;
    };
});