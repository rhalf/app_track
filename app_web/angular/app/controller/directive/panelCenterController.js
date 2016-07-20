var app = angular.module('app');


app.controller('panelCenterController', function ($scope, uiFactory) {

    $scope.init = function () {
        $scope.ui = uiFactory;
    };

});