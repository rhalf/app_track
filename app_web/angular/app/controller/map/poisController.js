var app = angular.module('app');


app.controller('poisController', function (
    $scope,
    $timeout,
    $location,
     $uibModal,
    

    authFactory,
    flagFactory,
    uiFactory,

   Poi

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;
  
        $scope.load();
    };

    $scope.load = function () {
        $scope.pois = Poi.getByCompany({company : $scope.authCompany.id })
    };

    $scope.select = function (poi) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/poi_update.html',
            controller: 'poiUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                poi: poi,
                parent: $scope
            }
        });
    };

    $scope.delete = function (poi) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/poi_delete.html',
            controller: 'poiDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                poi: poi,
                parent: $scope
            }
        });
    };

    $scope.add = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/poi_insert.html',
            controller: 'poiInsertController',
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

