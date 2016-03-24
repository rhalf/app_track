var app = angular.module('app');

app.controller('formController', function ($scope, panelLeftFactory) {
    //$scope.click = function () {
    //    $uibModal.open({
    //        templateUrl: 'app/template/directive/panelCenter.html'
    //    });
    //};

    $scope.toggle = function () {
        return panelLeftFactory.toggle;
    };
});

