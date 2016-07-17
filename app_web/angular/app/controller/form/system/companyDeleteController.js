var app = angular.module('app');


app.controller('companyDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,

    Company,
    CompanyInfo,

    company,
    parent

    ) {



    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.company = company;
    }

    $scope.delete = function () {
        Company.delete({ id: $scope.company.Id }, function (result) {
            parent.load();
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

