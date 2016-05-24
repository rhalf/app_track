var app = angular.module('app');

app.directive('datetimeDirective', function ($filter) {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModelController) {
            ngModelController.$parsers.push(function (value) {
                // Do to model conversion
                var dtLocal = new Date(value);

                var dtUtc = new Date(
                    dtLocal.getUTCFullYear(),
                    dtLocal.getUTCMonth(),
                    dtLocal.getUTCDate(),
                    dtLocal.getUTCHours(),
                    dtLocal.getUTCMinutes(),
                    dtLocal.getUTCSeconds(),
                    dtLocal.getUTCMilliseconds()
                )

             

                var utcString = $filter('date')(dtUtc, 'yyyy-MM-dd HH:mm:ss')

             
                //console.log("================ToModel");
                //console.log(dtLocal.toUTCString());
                //console.log(dtUtc);
                return utcString;

            });

            ngModelController.$formatters.push(function (value) {
                // Do to view conversion, possibly using $filter('date')
                var datetime = null
                if (value == null || value == 'undefined') {
                    datetime = new Date();
                } else {
                    datetime = new Date(value);
                }

                var dtUtc = new Date(
                    Date.UTC(
                        datetime.getFullYear(),
                        datetime.getMonth(),
                        datetime.getDate(),
                        datetime.getHours(),
                        datetime.getMinutes(),
                        datetime.getSeconds(),
                        datetime.getMilliseconds()
                    )
                );

                var dtLocal = new Date(dtUtc.toLocaleString());

                //console.log("================ToView");
                //console.log(dtUtc.toLocaleString());
                return dtLocal;
            });
        }
    }
});
