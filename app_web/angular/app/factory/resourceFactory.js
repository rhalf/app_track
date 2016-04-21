var app = angular.module('app');


app.factory('resourceFactory', function ($resource) {

    var resourceFactory = {};


    resourceFactory.company = function () {
        return $resource('http://184.107.179.181/v1/main/company/:companyId', { companyId: '@companyId' },
            {
                update: {
                    method: 'PUT',
                }
            });
    }
    resourceFactory.status = function () {
        return $resource('http://184.107.179.181/v1/main/status/:statusId', { statusId: '@statusId' });
    }
    resourceFactory.user = function () {
        return $resource('http://184.107.179.181/v1/main/user/:userId', { userId: '@userId' });
    }

    return resourceFactory;
});