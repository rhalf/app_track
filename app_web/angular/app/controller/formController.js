var app = angular.module('app');

app.controller('formController', function ($scope, panelLeftFactory) {
    $scope.toggle = function () {
        //console.log(panelLeftFactory);
        return panelLeftFactory.toggle;
    };
});




//$scope.click = function () {
//    $uibModal.open({
//        templateUrl: 'app/template/directive/panelCenter.html'
//    });
//};
