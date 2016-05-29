var app = angular.module('app');


app.controller('companyDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    CompanyInfo,

    company,
    parent

    ) {

    $scope.form = {};


    $scope.form.init = function () {
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();
    }

    $scope.form.load = function () {
        $scope.Company = company;

    }

    $scope.delete = function () {
        Company.delete({ id: $scope.Company.Id }, function (result) {
            parent.load();
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.form.init();
    $scope.form.load();
});

