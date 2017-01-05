var app = angular.module('app');


app.controller('ctPoiDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    leafletFactory,

    Poi,

    poi,
    parent

    ) {
    

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.poi = poi;
    }

    $scope.delete = function () {
        Poi.delete({ id: $scope.poi.Id }, function (result) {
            leafletFactory.loadPoi();
            parent.load();
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

