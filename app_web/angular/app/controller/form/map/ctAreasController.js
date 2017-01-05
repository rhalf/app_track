var app = angular.module('app');


app.controller('ctAreasController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

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
        $scope.areas = Area.getByNation({ nation: $scope.flag.Nations[178].Id });
    };

    $scope.select = function (area) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_area_update.html',
            controller: 'ctAreaUpdateController',
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
            templateUrl: 'app/view/form/map/ct_area_delete.html',
            controller: 'ctAreaDeleteController',
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
            templateUrl: 'app/view/form/map/ct_area_insert.html',
            controller: 'ctAreaInsertController',
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

