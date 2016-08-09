var app = angular.module('app');


app.controller('vehicleUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Vehicle,
    Unit,
    Driver,


    vehicle,
    parent
    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {
        $scope.toggle();

        $scope.ui.isLoading = true;


        Vehicle.update(
            { id: $scope.vehicle.Id },
            $scope.vehicle,
        function (result) {
            //Success
            var alert = { type: 'success', message: '1 vehicle has been updated successfully.' };
            $scope.ui.alert.addItem(alert);
            $scope.ui.isLoading = false;
            parent.load();
        },
        function (result) {
            //Failed
            var alert = { type: 'danger', message: result.data.Message };
            $scope.ui.alert.addItem(alert);
            $scope.ui.isLoading = false;

        });

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

        $scope.ui = uiFactory;
        $scope.ui.dateTimePicker.isOpen = [
            false, //dateTimePicker1
            false  //dateTimePicker2
        ];
        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.ui.alert.items = [];

        $scope.vehicle = vehicle;
        $scope.companies = Company.query();
        $scope.units = Unit.getByCompany({ company: $scope.authUser.Company.Id });
        $scope.drivers = Driver.getByCompany({ company: $scope.authUser.Company.Id });

    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.clearDriver = function () {
        $scope.vehicle.Driver = null;
    };

    $scope.clearUnit = function () {
        $scope.vehicle.Unit = null;
    };

    $scope.init();
});

