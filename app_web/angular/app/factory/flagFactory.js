var app = angular.module('app');


app.factory('flagFactory', function (
    $q,
    $timeout,

    Status,
    Field,
    Privilege,
    Nation,
    SimVendor,
    UnitStatus,
    UnitType,
    TrackeeType

    ) {
    var flagFactory = {};

    flagFactory.Statuses = {};
    flagFactory.Fields = {};
    flagFactory.Privileges = {};
    flagFactory.Nations = {};
    flagFactory.SimVendors = {};
    flagFactory.UnitStatuses = {};
    flagFactory.UnitTypes = {};
    flagFactory.TrackeeTypes = {};




    flagFactory.load = function (type) {
        switch (type) {
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
            case 'unitstatuses':
                flagFactory.UnitStatuses = UnitStatus.query();
                break;
            case 'unittypes':
                flagFactory.UnitTypes = UnitType.query();
                break;
            case 'trackeetypes':
                flagFactory.TrackeeTypes = TrackeeType.query();
                break;
        }
    };

    flagFactory.init = function (callback) {
        console.log("<-=======Loading data started=======->");
        var promises = $q.all(
            [
                Status.query(),
                Field.query(),
                Privilege.query(),
                Nation.query(),
                SimVendor.query(),
                UnitStatus.query(),
                UnitType.query(),
                TrackeeType.query()
            ]
        );

        promises.then(function (result) {
            console.log(result);
            flagFactory.Statuses = result[0];
            flagFactory.Fields = result[1];
            flagFactory.Privileges = result[2];
            flagFactory.Nations = result[3];
            flagFactory.SimVendors = result[4];
            flagFactory.UnitStatuses = result[5];
            flagFactory.UnitTypes = result[6];
            flagFactory.TrackeeTypes = result[7];

            console.log("<-=======Loading data finished======->");
            if (callback) {
                callback();
            }
        });
    };

    return flagFactory;
});