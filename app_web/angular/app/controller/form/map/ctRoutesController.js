var app = angular.module('app');


app.controller('ctRoutesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

   Route

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.routes = Route.getByCompany({ company : $scope.authUser.Company.Id});
    };

    $scope.select = function (route) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_route_update.html',
            controller: 'ctRouteUpdateController',
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
            templateUrl: 'app/view/form/map/ct_route_delete.html',
            controller: 'ctRouteDeleteController',
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
            templateUrl: 'app/view/form/map/ct_route_insert.html',
            controller: 'ctRouteInsertController',
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

