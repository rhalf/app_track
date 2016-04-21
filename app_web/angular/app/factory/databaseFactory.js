var app = angular.module('app');


app.factory('databaseFactory', function () {
    var databaseFactory = [];

    databaseFactory.company = [];
    databaseFactory.status = [];
    databaseFactory.user = [];



    databaseFactory.getCompanyById = function (id) {
        for (index in databaseFactory.company) {
            if (databaseFactory.company[index].Id == id) {
                return databaseFactory.company[index];
            }
        }
    }

    databaseFactory.getStatusByValue = function (value) {
        for (index in databaseFactory.status) {
            if (databaseFactory.status[index].Value == value) {
                return databaseFactory.status[index];
            }
        }
    }


    return databaseFactory;
});