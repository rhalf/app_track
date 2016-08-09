var app = angular.module('app');


app.controller('ctUnitsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    Unit

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.ui = uiFactory;

        $scope.units = [];

        Unit.getByCompany(
        { company: $scope.authUser.Company.Id },
        function (result) {
            $scope.units = result;
        },
        function (result) {
            var alert = { type: 'success', message: result.data.Message };
            $scope.ui.alert.addItem(alert);
        });
    };


    $scope.select = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_unit_update.html',
            controller: 'ctUnitUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                unit: unit
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };


    $scope.init();
});

