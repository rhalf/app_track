var app = angular.module('app');

app.controller('panelContainerController', function (
    $scope,
    uiFactory,
    flagFactory
    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
    };

    $scope.init();
});