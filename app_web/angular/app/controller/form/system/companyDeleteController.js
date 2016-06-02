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

    company

    ) {



    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.company = company;
    }

    $scope.delete = function () {
        Company.delete({ id: $scope.company.Id }, function (result) {
            $scope.flag.load('companies');
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

