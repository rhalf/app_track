var app = angular.module('app');


app.controller('ctCollectionDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,

    Collection,

    collection,
    parent

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.collection = collection;
    }

    $scope.delete = function () {
        $scope.ui.isLoading = true;
        Collection.delete({ id: $scope.collection.Id }, function (result) {
            parent.load();
            $scope.ui.isLoading = false;
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

