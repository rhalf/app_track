var app = angular.module('app');


app.controller('poiDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal, 
    $uibModalInstance,



    authFactory,
    flagFactory,
    uiFactory,
    leafletFactory,

    Poi,

    poi,
    parent

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;

        $scope.authUser = authFactory.getUser();

        $scope.poi = poi;
    }

    $scope.delete = function () {
        Poi.delete({ id: $scope.poi.id },
        //Success
        function (result) {
            leafletFactory.loadPoi();
            parent.load();
            $scope.ui.isLoading = false;

            var alert = { type: 'success', message: result.message };
            $scope.ui.alert.show(alert);
            $scope.cancel();
        },
        //Failed
        function (result) {
            $scope.ui.isLoading = false;

            var alert = { type: 'danger', message: result.data.message };
            $scope.ui.alert.show(alert);
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };


    $scope.init();
});

