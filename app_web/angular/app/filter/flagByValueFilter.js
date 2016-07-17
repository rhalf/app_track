var app = angular.module('app');

app.filter('flagByValueFilter', function () {
    return function (value, array, option) {
        var result = "UNKNOWN";

        angular.forEach(array, function (object) {
            if (object.Value === value) {
                switch (option) {
                    case 'name':
                        result = object.Name;
                        break;
                    case 'desc':
                        result = object.Desc;
                        break;
                    default:
                        result = object.Name;
                }
            }
        });

        return result;
    }
});