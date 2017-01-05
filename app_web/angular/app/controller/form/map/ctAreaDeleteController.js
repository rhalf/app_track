var app = angular.module('app');


app.controller('ctAreaDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    leafletFactory,

    Area,

    area,
    parent

    ) {
    

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.area = area;
    }

    $scope.delete = function () {
        Area.delete({ id: $scope.area.Id }, function (result) {
            leafletFactory.loadArea();
            parent.load();
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

