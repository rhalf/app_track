var app = angular.module('app');


app.controller('unitInsertController', function (
    $q,
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,
    validationFactory,


    Unit

    ) {

    //Form
    $scope.add = function () {
        Unit.save(
            $scope.unit,
            function (result) {
                //Success
                var alert = { type: 'success', message: '1 unit has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                $scope.flag.load('units');
            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.data.Message };
                $scope.ui.alert.addItem(alert);
                return;
            });
    };


    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }



    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.ui = uiFactory;

        $scope.ui.alert.items = [];
        $scope.unit = new Unit();
    }


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.clearSim = function () {
        $scope.unit.Sim = 0;
    }

    $scope.init();
});

