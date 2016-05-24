var app = angular.module('app');

app.filter('fieldFilter', function ($filter, flagFactory) {
    return function (id) {
        var result = "UNKNOWN";
        angular.forEach(flagFactory.Field, function (field) {
            if (field.Id === id) {
                result = field.Name;
            }
        });
        return result;
    }
});