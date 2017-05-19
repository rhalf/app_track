var app = angular.module('app');


app.controller('areasController', function (
    $scope,
    $timeout,
    $location,
     $uibModal,
    

    authFactory,
    flagFactory,
    uiFactory,

   Area

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.areas = Area.getByNation({ nation: $scope.flag.nations[178].id });
    };

    $scope.select = function (area) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/area_update.html',
            controller: 'areaUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                area: area,
                parent: $scope
            }
        });
    };

    $scope.delete = function (area) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/area_delete.html',
            controller: 'areaDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                area: area,
                parent: $scope
            }
        });
    };

    $scope.add = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/area_insert.html',
            controller: 'areaInsertController',
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

