var app = angular.module('app');

app.filter('nationFilter', function ($filter, flagFactory) {
    return function (id, option) {
        var result = "UNKNOWN";

        angular.forEach(flagFactory.Nation, function (object) {
            if (object.Id === id) {
                switch (option) {
                    case 'nameShort':
                        result = object.NameShort;
                        break;
                    case 'nameLong':
                        result = object.NameLong;
                        break;
                    case 'dialCode':
                        result = object.DialCode;
                        break;
                    default:
                        result = object.NameShort;
                }
            }
        });
        return result;
    }
});