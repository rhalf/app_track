var app = angular.module('app');


app.controller('unitsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,

    Unit

    ) {

    $scope.form = {};

    $scope.form.init = function () {
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();
    }

    $scope.form.load = function () {
        Unit.query(function (units) {
            $scope.Units = units;
        });
    }

    $scope.select = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/unit_update.html',
            controller: 'unitUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                unit: unit,
                parent: $scope
            }
        });
    }
    $scope.delete = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/unit_delete.html',
            controller: 'unitDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                unit: unit,
                parent: $scope
            }
        });
    }

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/unit_insert.html',
            controller: 'unitInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    }

    $scope.credential = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/user_update_credential.html',
            controller: 'userUpdateCredentialController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: unit,
                parent: $scope
            }
        });
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.form.init();
    $scope.form.load();
});

