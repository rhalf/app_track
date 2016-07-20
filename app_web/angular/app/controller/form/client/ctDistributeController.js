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
        $scope.authCompany = authFactory.getCompany();
        $scope.ui = uiFactory;
        $scope.fleet = fleetFactory;
    };

    $scope.add = function (collection) {

        if (!collection) {
            return;
        }

        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_distribute_insert.html',
            controller: 'ctDistributeInsertController',
            keyboard: true,
            size: 'lg',
            resolve: {
                collection: collection,
                parent : $scope
            }
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

