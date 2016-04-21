var app = angular.module('app');


app.service('statusService', function ($resource, statusFactory) {


    this.getObject = function (id) {
        for (object in statusFactory) {
            if (object.Id = id) {
                return object;
            }
        }
    }

    this.getArray = function () {
        return statusFactory;
    }
});