var app = angular.module('app');


app.controller('areaDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,



    authFactory,
    flagFactory,
    uiFactory,
    leafletFactory,

    Area,

    area,
    parent

    ) {
    

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.authUser = authFactory.getUser();

        $scope.area = area;
    }

    $scope.delete = function () {
        Area.delete({ id: $scope.area.id },
        //Success
        function (result) {
            leafletFactory.loadArea();
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

