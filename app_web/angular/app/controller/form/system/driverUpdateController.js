var app = angular.module('app');


app.controller('driverUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Driver,

    driver,
    parent

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    }

    $scope.update = function () {
        $scope.ui.isLoading = true;

        Driver.update(
            { id: $scope.driver.Id },
            $scope.driver,

            function (result) {
                //Success
                    var alert = { type: 'success', message: '1 driver has been updated successfully.' };
                    $scope.ui.alert.addItem(alert);
                    parent.load();
                    $scope.toggle();
                    $scope.ui.isLoading = false;
            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.Message };
                $scope.ui.alert.addItem(alert);
                $scope.toggle();
                $scope.ui.isLoading = false;

            }
        );
    }

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

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

        $scope.driver = driver;
        $scope.companies = Company.query();
    }
    
    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

