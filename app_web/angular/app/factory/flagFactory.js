var app = angular.module('app');


app.factory('flagFactory', function (
    $q,
    $timeout,

    Company,
    Status,
    Field,
    Privilege,
    Company,
    Nation,
    SimVendor,
    Sim,
    Unit,
    UnitStatus,
    UnitType,
    User,
    Driver

    ) {
    var flagFactory = {};

    flagFactory.Companies = {};
    flagFactory.Statuses = {};
    flagFactory.Fields = {};
    flagFactory.Privileges = {};
    flagFactory.Nations = {};
    flagFactory.SimVendors = {};
    flagFactory.Sims = {};
    flagFactory.Units = {};
    flagFactory.UnitStatuses = {};
    flagFactory.UnitTypes = {};
    flagFactory.Users = {};
    flagFactory.Drivers = {};


    flagFactory.load = function (type) {
        switch (type) {
            case 'companies':
                flagFactory.Companies = Company.query();
                break;
            case 'statuses':
                flagFactory.Statuses = Status.query();
                break;
            case 'fields':
                flagFactory.Fields = Field.query();
                break;
            case 'privileges':
                flagFactory.Privileges = Privilege.query();
                break;
            case 'nations':
                flagFactory.Nations = Nation.query();
                break;
            case 'simvendors':
                flagFactory.SimVendors = SimVendor.query();
                break;
            case 'sims':
                flagFactory.Sims = Sim.query();
                break;
            case 'units':
                flagFactory.Units = Unit.query();
                break;
            case 'unitstatuses':
                flagFactory.UnitStatuses = UnitStatus.query();
                break;
            case 'unittypes':
                flagFactory.UnitTypes = UnitType.query();
                break;
            case 'users':
                flagFactory.Users = User.query();
                break;
            case 'drivers':
                flagFactory.Drivers = Driver.query();
                break;
        }
    };

    flagFactory.init = function (callback) {
        console.log("<-=======Loading data started=======->");
        var promises = $q.all(
            [
                Company.query(),
                Status.query(),
                Field.query(),
                Privilege.query(),
                Nation.query(),
                SimVendor.query(),
                Sim.query(),
                Unit.query(),
                UnitStatus.query(),
                UnitType.query(),
                User.query(),
                Driver.query()
            ]
        );

        promises.then(function (result) {
            console.log(result);
            flagFactory.Companies = result[0];
            flagFactory.Statuses = result[1];
            flagFactory.Fields = result[2];
            flagFactory.Privileges = result[3];
            flagFactory.Nations = result[4];
            flagFactory.SimVendors = result[5];
            flagFactory.Sims = result[6];
            flagFactory.Units = result[7];
            flagFactory.UnitStatuses = result[8];
            flagFactory.UnitTypes = result[9];
            flagFactory.Users = result[10];
            flagFactory.Drivers = result[11];


            console.log("<-=======Loading data finished======->");
            callback();
        });
    };

    return flagFactory;
});