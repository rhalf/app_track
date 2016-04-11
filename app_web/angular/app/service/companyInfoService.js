var app = angular.module('app');


app.service('companyInfoService', function ($http) {

    this.getById = function (id, callback) {

        $http({
            url: 'http://184.107.179.181/v1/main/company/' + id,
            method: 'GET',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        })
       .success(function (data, status, headers, config) {
           console.log(data);
           callback(data.Object[0]);
       })
       .error(function (data, status, header, config) {
           console.log(status);
           callback(null);
       });
    };
});