var app = angular.module('app');


app.controller('ctRouteDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    leafletFactory,

    Route,

    route,
    parent

    ) {
    

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.route = route;
    }

    $scope.delete = function () {
        Route.delete({ id: $scope.route.Id }, function (result) {
            leafletFactory.loadRoute();
            parent.load();
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

