var app = angular.module('app');


app.controller('companyController', function (
    $scope,
    $location,
    $uibModal,

    
    authFactory,
    databaseFactory) {

    $scope.status = databaseFactory.status;
    $scope.factory = databaseFactory;



    $scope.form = {};
    $scope.form.isDisabled = true;


    $scope.User = authFactory.getAccessToken();

    $scope.company = databaseFactory.getCompanyById($scope.User.Company);


    console.log($scope.company);


  

    $scope.form.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    }

    $scope.form.save = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
        $scope.company.save();
    }


});

