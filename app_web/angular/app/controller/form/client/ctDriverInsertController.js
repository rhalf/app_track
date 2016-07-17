var app = angular.module('app');


app.controller('ctDriverInsertController', function (
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,
    
    Driver,
    Company,

    parent

    ) {

    //Form
    $scope.add = function () {
      
        $scope.ui.isLoading = false;

        $scope.driver.Name = $scope.driver.NameLast + ", " + $scope.driver.NameFirst + " " + $scope.driver.NameMiddle;

        Driver.save($scope.driver,
            //Success
            function (result) {
                var alert = { type: 'success', message: '1 driver has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                parent.load();
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

        $scope.driver = new Driver();
        $scope.companies = Company.query();

    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

