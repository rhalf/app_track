var app = angular.module('app');


app.controller('companiesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.ui = uiFactory;
    }

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
                company: company
            }
        });
    }

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/company_insert.html',
            controller: 'companyInsertController',
            keyboard: true,
            size: 'md'
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
                company: company
            }
        });
    };

    $scope.clearCompany = function () {
        $scope.selectedCompany = "";
    };

    $scope.init();
});

