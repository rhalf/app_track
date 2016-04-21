var app = angular.module('app');


app.factory('statusFactory', function () {
    var statusFactory = {};

    statusFactory.objects = [];

    statusFactory.getById = function(id) {
        for (object in statusFactory.objects) {
            if (object.Id == id) {
                return object;
            }
        }
    }


    return statusFactory;
});