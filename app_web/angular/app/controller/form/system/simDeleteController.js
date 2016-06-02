var app = angular.module('app');


app.controller('simDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,

    Sim,

    sim

    ) {



    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.sim = sim;
    }

    $scope.delete = function () {
        Sim.delete({ id: $scope.sim.Id }, function (result) {
            $scope.flag.load('sims');
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

