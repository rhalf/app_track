var app = angular.module('app');


app.controller('ctCollectionInsertController', function (
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,

    Collection,
    Company,
    User,

    parent

    ) {

    //Form
    $scope.add = function () {

        $scope.ui.isLoading = true;

        Collection.save($scope.collection,
            //Success
            function (result) {
                var alert = { type: 'success', message: '1 collection has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                parent.load();
                $scope.fleet.load();
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
    };

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();

        $scope.ui = uiFactory;

        $scope.fleet = fleetFactory;

        $scope.ui.alert.items = [];

        $scope.collection = new Collection();
        $scope.companies = Company.query();
        $scope.users = User.getByCompany({ company: $scope.authUser.Company.Id });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

