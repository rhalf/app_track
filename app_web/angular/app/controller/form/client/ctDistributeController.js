var app = angular.module('app');


app.controller('ctDistributeController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    fleetFactory

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;
        $scope.fleet = fleetFactory;
    };

    $scope.addRemove = function () {

        if (!$scope.selected) {
            var alert = { type: 'danger', message: 'Select collection first.' };
            $scope.ui.alert.addItem(alert);
            return;
        }

        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_distribute_insert.html',
            controller: 'ctDistributeInsertController',
            keyboard: true,
            size: 'lg',
            resolve: {
                collection: $scope.selected
            }
        });
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

