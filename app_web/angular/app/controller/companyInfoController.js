var app = angular.module('app');


app.controller('companyInfoController', function ($scope, $location, $uibModal, companyInfoService, authFactory) {

    $scope.user = authFactory.getAccessToken();
    $scope.companyInfo = {};

    companyInfoService.getById($scope.user.Company, function (object) {
        $scope.companyInfo = object;
    });

});

