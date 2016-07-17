var app = angular.module('app');


app.controller('ctCollectionUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Collection,
    User,
    
    collection,
    parent

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {
        $scope.ui.isLoading = true;

        Collection.update(
            { id: $scope.collection.Id },
            $scope.collection,

            function (result) {
                //Success
                var alert = { type: 'success', message: '1 collection has been updated successfully.' };
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
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    };

    $scope.clearUser = function () {
        $scope.collection.User = null;
    };

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;

        $scope.ui.alert.items = [];

        $scope.collection = collection;
        $scope.companies = Company.query();
        $scope.users = User.getByCompany({ company: $scope.authCompany.Id });

    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

