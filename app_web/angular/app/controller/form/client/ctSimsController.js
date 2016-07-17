var app = angular.module('app');


app.controller('ctSimsController', function (
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


    $scope.load = function () {
        $scope.sims = Sim.getByCompany({ company: $scope.authCompany.Id });
    };

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;

        $scope.load();
    };



    $scope.select = function (sim) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_sim_update.html',
            controller: 'ctSimUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                sim: sim
            }
        });
    };

    $scope.clear = function () {
        $scope.selected = "";
    };



    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

