var app = angular.module('app');


app.factory('systemFactory', function (


    ) {

    var systemFactory = {};
    systemFactory.app = {};
    systemFactory.app.Name = "Gaia Watcher";
    systemFactory.app.Version = "0.1";

    systemFactory.app.Company = {};
    systemFactory.app.Company.Name = "Advanced Technologies and Solutions";
    systemFactory.app.Company.Address = "Office #10 (2nd Floor) Darwish Bldg. Salwa Road, Abu hamour, Qatar";
    systemFactory.app.Company.Mobile = "Office #10 (2nd Floor) Darwish Bldg. Salwa Road, Abu hamour, Qatar";
    systemFactory.app.Company.Email = "info@ats-qatar.com";
    systemFactory.app.Company.Mobile = "(974)30599362";
    systemFactory.app.Company.Telephone = "(974)44876611";





    return systemFactory;
});