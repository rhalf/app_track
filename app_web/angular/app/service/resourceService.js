var app = angular.module('app');


app.service('resourceService', function (

    resourceFactory,
    databaseFactory

    ) {

    this.init = function () {
        this.initCompany();
        this.initStatus();
    }

    this.initCompany = function () {
        var instance = resourceFactory.company();
        var result = instance.get();

        result.$promise.then(function (datas) {
            databaseFactory.company = datas.Object;
            //console.log(databaseFactory.company);
        });
    }

    this.initStatus = function () {
        var instance = resourceFactory.status();
        var result = instance.get();

        result.$promise.then(function (datas) {
            databaseFactory.status = datas.Object;
            //console.log(databaseFactory.status);
        });
    }

});