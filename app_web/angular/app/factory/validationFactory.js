var app = angular.module('app');


app.factory('validationFactory', function () {

    var validationFactory = {};

    validationFactory.password = {};

    validationFactory.password.notMatch = function (pass1, pass2) {
        if (pass1 == pass2) {
            return false;
        } else {
            console.log("notMatch");
            return true;
        }
    };

    validationFactory.password.isShort = function (pass1, pass2) {
        var pass1 = new String(pass1);
        var pass2 = new String(pass2);

        if (pass1.length > 5 && pass2.length > 5) {
            return false;
        } else {
            console.log("isShort");
            return true;
        }
    };

    return validationFactory;
});

