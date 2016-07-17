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
        var str1 = new String(pass1);
        var str2 = new String(pass2);

        if (str1.length < 6 || str2.length < 6) {
            console.log("isShort");
            return true;
        } else if (pass1 == null || pass2 == null) {
            return true;
        } else {
            return false;
        }
    };

    validationFactory.isNullOrEmpty = function (pass1) {
        var str1 = new String(pass1);
        if (str1.length < 1) {
            return true;
        } else if (pass1 == null){
            return true;
        } else {
            return false;
        }
    };


    return validationFactory;
});

