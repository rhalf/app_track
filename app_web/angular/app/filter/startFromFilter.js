var app = angular.module('app');

app.filter('startFromFilter', function () {
    return function (input, index) {
        return input.slice(index);
    };
});