var app = angular.module('app');

app.controller('appController', function (
    $scope,
    $timeout,
    flagFactory,
    uiFactory) {
    $scope.$on('$viewContentLoaded', function (event) {
        $timeout(function () {
            $scope.ui.isLoading = false;
        }, 500);
    });

    $scope.init = function () {
        $scope.ui = uiFactory;
    };

    $scope.init();
});

