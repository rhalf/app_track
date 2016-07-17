var app = angular.module('app');

app.filter('flagByIdFilter', function () {
    return function (id, array, option) {
        var result = "UNKNOWN";

        angular.forEach(array, function (object) {
            if (object.Id === id) {
                switch (option) {
                    case 'name':
                        result = object.Name;
                        break;
                    case 'fullname':
                        result = object.NameLast + ", " + object.NameFirst + " " + object.NameMiddle;
                        break;
                    case 'number':
                        result = object.Number;
                        break;
                    case 'imei':
                        result = object.Imei;
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