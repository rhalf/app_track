var app = angular.module('app');


app.controller('ctPoisController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

   Poi

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;
  
        $scope.load();
    };

    $scope.load = function () {
        $scope.pois = Poi.getByCompany({company : $scope.authUser.Company.Id })
    };

    //$scope.select = function (collection) {
    //    $uibModal.open({
    //        animation: true,
    //        templateUrl: 'app/view/form/client/ct_collection_update.html',
    //        controller: 'ctCollectionUpdateController',
    //        keyboard: true,
    //        size: 'md',
    //        resolve: {
    //            collection: collection,
    //            parent: $scope
    //        }
    //    });
    //};

    //$scope.delete = function (collection) {
    //    $uibModal.open({
    //        animation: true,
    //        templateUrl: 'app/view/form/client/ct_collection_delete.html',
    //        controller: 'ctCollectionDeleteController',
    //        keyboard: true,
    //        size: 'md',
    //        resolve: {
    //            collection: collection,
    //            parent: $scope
    //        }
    //    });
    //};

    $scope.add = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/map/ct_poi_insert.html',
            controller: 'ctPoiInsertController',
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

