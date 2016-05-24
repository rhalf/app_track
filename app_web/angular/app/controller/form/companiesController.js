var app = angular.module('app');


app.controller('companiesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,

    Company

    ) {

    $scope.form = {};

    $scope.form.init = function () {
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();
    }

    $scope.form.load = function () {
        $scope.Companies = Company.query();
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.select = function (company) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/company_update.html',
            controller: 'companyUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                company: company,
                parent: $scope
            }
        });
    }

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/company_insert.html',
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
            templateUrl: 'app/view/form/company_delete.html',
            controller: 'companyDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                company: company,
                parent: $scope
            }
        });
    }

    $scope.form.init();
    $scope.form.load();
});

