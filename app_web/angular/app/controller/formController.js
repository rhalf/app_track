var app = angular.module('app');

app.controller('formController', function ($scope, panelLeftFactory) {
    $scope.getToggle = function () {
        //console.log(panelLeftFactory);
        return panelLeftFactory.toggle;
    };
});




//$scope.click = function () {
//    $uibModal.open({
//        templateUrl: 'app/template/directive/panelCenter.html'
//    });
//};
