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
    
    Sim

    ) {

    //Form
    $scope.add = function () {
        Sim.save($scope.sim,
            //Success
            function (result) {
                var alert = { type: 'success', message: '1 sim has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                $scope.flag.load('sims');
            },
            //Failed
            function (result) {
                var alert = { type: 'danger', message: result.data.Message };
                $scope.ui.alert.addItem(alert);
            }
        );
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }



    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.ui = uiFactory;

        $scope.ui.dateTimePicker.isOpen = [
                 false, //dateTimePicker1
                 false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.ui.alert.items = [];

        $scope.sim = new Sim();
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

