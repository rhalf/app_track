var app = angular.module('app');


app.controller('ctCollectionsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    Collection,
    Company,
    User

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();
        $scope.ui = uiFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.collections = Collection.getByCompany({ company: $scope.authCompany.Id });
        $scope.companies = Company.query();
        $scope.users = User.getByCompany({ company: $scope.authCompany.Id });

    };

    $scope.select = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_collection_update.html',
            controller: 'ctCollectionUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                collection: collection,
                parent: $scope
            }
        });
    };

    $scope.delete = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_collection_delete.html',
            controller: 'ctCollectionDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                collection: collection,
                parent: $scope
            }
        });
    };

    $scope.add = function (collection) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_collection_insert.html',
            controller: 'ctCollectionInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };


    $scope.clear = function () {
        $scope.selected = "";
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

