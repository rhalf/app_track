var app = angular.module('app');


app.controller('simsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Sim

    ) {


    $scope.init = function () {
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();
        $scope.pagination = uiFactory.pagination;
    }

    $scope.load = function () {
        $scope.Sims = Sim.query();
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.select = function (sim) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/sim_update.html',
            controller: 'simUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                sim: sim,
                parent: $scope
            }
        });
    }

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/sim_insert.html',
            controller: 'simInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    }

    $scope.delete = function (sim) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/sim_delete.html',
            controller: 'simDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                sim: sim,
                parent: $scope
            }
        });
    }

    $scope.init();
    $scope.load();
});

