var app = angular.module('app');

app.filter('startFromFilter', function () {
    return function (input, index) {

        if (input == null) {
            return input;
        }

        if (index < (input.length + 1)) {
            return input.slice(index);
        } else {
            return input;
        }
    };
});