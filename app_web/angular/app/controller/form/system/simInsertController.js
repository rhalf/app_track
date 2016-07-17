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
    
    Company,
    Sim,

    parent

    ) {

    //Form
    $scope.add = function () {

        $scope.ui.isLoading = true;

        Sim.save($scope.sim,
            //Success
            function (result) {
                var alert = { type: 'success', message: '1 sim has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                parent.load();
                $scope.ui.isLoading = false;

            },
            //Failed
            function (result) {
                var alert = { type: 'danger', message: result.data.Message };
                $scope.ui.alert.addItem(alert);
                $scope.ui.isLoading = false;

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

        $scope.sim = new Sim();
        $scope.companies = Company.query();

    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

