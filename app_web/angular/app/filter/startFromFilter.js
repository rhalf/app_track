var app = angular.module('app');

app.filter('startFromFilter', function () {
    return function (input, index) {
        if (input > 0) {
            return input.slice(index);
        } else {
            return input;
        }
    };
});