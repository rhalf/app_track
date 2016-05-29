var app = angular.module('app');


app.controller('simInsertController', function (
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,


    Sim,
    parent

    ) {

    //DateTime
    $scope.dateTimePicker = uiFactory.dateTimePicker;
    $scope.dateTimePicker.isOpen = [
        false, //dateTimePicker1
        false  //dateTimePicker2
    ];
    $scope.dateTimePicker.toggle = function (index) {
        $scope.dateTimePicker.isOpen[index] = !$scope.dateTimePicker.isOpen[index];
    };

    //Form

    $scope.add = function () {
        Sim.save($scope.Sim,
            //Success
            function (result) {
                var alert = { type: 'success', message: '1 sim has been added successfully.' };
                $scope.alert.addItem(alert);
                parent.load();
            },
            //Failed
            function (result) {
                var alert = { type: 'danger', message: result.data.Message };
                $scope.alert.addItem(alert);
            }
        );
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.alert.closeItem(index);
    }


    $scope.init = function () {
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();

        uiFactory.alert.items = [];
        $scope.alert = uiFactory.alert;
    }


    $scope.load = function () {
        $scope.Sim = new Sim();
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
    $scope.load();
});

