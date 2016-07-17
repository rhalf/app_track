var app = angular.module('app');


app.controller('vehicleInsertController', function (
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

    Company,
    Vehicle,
    Unit,
    Driver,

    parent

    ) {

    //Form
    $scope.add = function () {
        $scope.ui.isLoading = true;

        Vehicle.save(
            $scope.vehicle,
            function (result) {
                //Success
                var alert = { type: 'success', message: '1 vehicle has been added successfully.' };
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
    }



    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;

        $scope.ui.dateTimePicker.isOpen = [
         false, //dateTimePicker1
         false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.ui.alert.items = [];

        $scope.vehicle = new Vehicle();
        $scope.companies = Company.query();
        $scope.units = Unit.getByCompany({ company: $scope.authCompany.Id });
        $scope.drivers = Driver.getByCompany({ company: $scope.authCompany.Id });

        console.log($scope.drivers);
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

