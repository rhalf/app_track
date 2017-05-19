var app = angular.module('app');


app.controller('routesController', function (
    $scope,
    $timeout,
    $location,
     $uibModal,


    authFactory,
    flagFactory,
    uiFactory,

   Route

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.routes = Route.getByCompany({ company : $scope.authCompany.id});
    };

    $scope.select = function (route) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/route_update.html',
            controller: 'routeUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                route: route,
                parent: $scope
            }
        });
    };

    $scope.delete = function (route) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/route_delete.html',
            controller: 'routeDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                route: route,
                parent: $scope
            }
        });
    };

    $scope.add = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/route_insert.html',
            controller: 'routeInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

