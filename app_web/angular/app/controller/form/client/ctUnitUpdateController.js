var app = angular.module('app');


app.controller('ctUnitUpdateController', function (
    $q,
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,
    validationFactory,

    
    Unit,
    Company,
    Sim,

    unit

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {
        $scope.toggle();

        $scope.ui.isLoading = true;

        Unit.update(
            { id: $scope.unit.Id },
            $scope.unit,

            function (result) {
                //Success
                var alert = { type: 'success', message: '1 unit has been updated successfully.' };
                $scope.ui.alert.addItem(alert);
                $scope.flag.load('units');
                $scope.ui.isLoading = false;

            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.Message };
                $scope.ui.alert.addItem(alert);
                $scope.ui.isLoading = false;

            }
        );
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    };

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();

        $scope.companies = Company.query();
        $scope.sims = Sim.query();


        $scope.ui = uiFactory;
        $scope.ui.dateTimePicker.isOpen = [
            false, //dateTimePicker1
            false  //dateTimePicker2
        ];
        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.ui.alert.items = [];

        $scope.unit = unit;
    };

    $scope.clearSim = function () {
        $scope.unit.Sim = null;
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

