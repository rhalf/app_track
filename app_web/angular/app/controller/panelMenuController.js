var app = angular.module('app');


app.controller('panelMenuController', function ($scope, panelLeftFactory, authFactory) {
    $scope.toggle = function () {
        panelLeftFactory.toggle = !panelLeftFactory.toggle;
        //console.log(panelLeftFactory);
    };

    
    $scope.user = authFactory.getAccessToken();

    console.log(authFactory.getAccessToken());

});

