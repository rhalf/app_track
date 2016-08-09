var app = angular.module('app');


app.controller('companiesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    //$uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Company

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        $scope.companies = Company.query();
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.select = function (company) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/company_update.html',
            controller: 'companyUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                company: company,
                parent : $scope
            }
        });
    }

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/company_insert.html',
            controller: 'companyInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    }

    $scope.delete = function (company) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/company_delete.html',
            controller: 'companyDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                company: company,
                parent: $scope
            }
        });
    };

    $scope.init();
});

