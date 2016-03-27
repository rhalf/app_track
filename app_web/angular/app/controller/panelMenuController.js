var app = angular.module('app');


app.controller('panelMenuController', function ($scope, panelLeftFactory) {
    $scope.toggle = function () {
        panelLeftFactory.toggle = !panelLeftFactory.toggle;
        //console.log(panelLeftFactory);
    };
});

