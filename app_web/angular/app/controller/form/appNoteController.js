var app = angular.module('app');

app.controller('appNoteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    appNote

    ) {

    $scope.init = function () {
        $scope.appNote = appNote;
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

