var app = angular.module('app');

app.controller('appController', function () {


});

app.run(function (
    $rootScope,
    $location,
    authFactory,

    $q,
    $timeout,
    uiFactory,
    flagFactory,

    Status,
    Field,
    Privilege,
    Company,
    Nation,
    SimVendor,
    Sim,
    UnitType

    ) {

    $rootScope.$on("$routeChangeStart", function (event, next, current) {

        //console.log(event);
        //console.log(next);
        //console.log(current);

        //If route is authenticated, then the user should have access
        if (next.$$route.authenticated) {

            console.log("<-=======Initizalization Started=======->");
            flagFactory.Status = Status.query();
            flagFactory.Field = Field.query();
            flagFactory.Privilege = Privilege.query();
            flagFactory.Nation = Nation.query();
            flagFactory.SimVendor = SimVendor.query();
            flagFactory.Sim = Sim.query();
            flagFactory.UnitType = UnitType.query();



            flagFactory.Company = Company.query();

            var promises = $q.all(
                [
                    flagFactory.Status,
                    flagFactory.Field,
                    flagFactory.Privilege,
                    flagFactory.Company,
                    flagFactory.Nation,
                    flagFactory.SimVendor,
                    flagFactory.Sim,
                    flagFactory.UnitType
                ]
            );

            promises.then(function () {
                //console.log(flagFactory.UnitSim);
                console.log("<-=======Initizalization Finished======->");

                uiFactory.isLoading = false;
                var user = authFactory.getAccessToken();

                if (!user) {
                    $location.path('/');
                }
            });
        }
    });
});


