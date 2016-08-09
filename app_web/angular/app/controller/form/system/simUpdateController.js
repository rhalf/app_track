var app = angular.module('app');


app.controller('simUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Sim,

    sim,
    parent

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    }

    $scope.update = function () {
        $scope.toggle();

        $scope.ui.isLoading = true;

        Sim.update(
            { id: $scope.sim.Id },
            $scope.sim,

            function (result) {
                //Success
                    var alert = { type: 'success', message: '1 sim has been updated successfully.' };
                    $scope.ui.alert.addItem(alert);
                    parent.load();
                    $scope.ui.isLoading = false;

            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.Message };
                $scope.ui.alert.addItem(alert);
                $scope.ui.isLoading = false;

            }
        );
    }

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();

        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.ui = uiFactory;
        $scope.ui.dateTimePicker.isOpen = [
            false, //dateTimePicker1
            false  //dateTimePicker2
        ];
        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.ui.alert.items = [];

        $scope.sim = sim;
        $scope.companies = Company.query();

    }
    
    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

