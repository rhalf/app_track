var app = angular.module('app');

app.filter('valueFromFilter', function () {
    return function (objects, value) {
        var items = [];
        angular.forEach(objects, function (object) {
            if (object.Value >= value) {
                items.push(object);
            }
        });
        return items;
    };
});