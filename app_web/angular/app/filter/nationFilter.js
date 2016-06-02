var app = angular.module('app');

app.filter('nationFilter', function (flagFactory) {
    function filter(id, option) {
        var result = "UNKNOWN";

        angular.forEach(flagFactory.Nations, function (object) {
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

    filter.$stateful = true;
    return filter;
});