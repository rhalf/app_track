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

    Company,
    Sim,
    Unit,

    parent

    ) {

    //Form
    $scope.add = function () {
        $scope.ui.isLoading = true;

        Unit.save(
            $scope.unit,
            function (result) {
                //Success
                var alert = { type: 'success', message: '1 unit has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                parent.load();
                $scope.ui.isLoading = false;

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

        $scope.ui = uiFactory;

        $scope.ui.alert.items = [];

        $scope.unit = new Unit();
        $scope.companies = Company.query();
        $scope.sims = Sim.getByCompany({ company: $scope.authUser.Company.Id });
    }


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.clearSim = function () {
        $scope.unit.Sim = null;
    }

    $scope.init();
});

