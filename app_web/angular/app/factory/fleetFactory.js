var app = angular.module('app');


app.factory('fleetFactory', function (
    Vehicle,
    Collection,
    VehicleCollection,
    Driver,
    Sim,
    Unit,

    authFactory

    ) {

    var fleetFactory = {};
    fleetFactory.vehicles = [];
    fleetFactory.collections = []

    fleetFactory.load = function (callback) {

        user = authFactory.getUser();

        Vehicle.getByCompany( user.Company.Id,
            function (vehicles) {

                fleetFactory.vehicles = vehicles;

                Collection.getByCompany(
                      { company: user.Company.Id },
                      function (collections) {
                          fleetFactory.collections = collections;

                          angular.forEach(fleetFactory.collections, function (collection, index) {
                              VehicleCollection.getByCollection(
                                  { collection: collection.Id },
                                  function (vehicleCollections) {
                                      collection.Vehicles = [];
                                      angular.forEach(vehicleCollections, function (vehicleCollection) {
                                          collection.Vehicles.push(vehicleCollection.Vehicle);
                                      });

                                      if (callback) {
                                          callback();
                                      }
                                  },
                                  function (result) {
                                      //Failed
                                  }
                              );
                          });
                      },
                      function (result) {
                          //Failed
                      });
            });
    };

    fleetFactory.update = function (collection, callback) {
        VehicleCollection.deleteByCollection(
            { collection: collection.Id },
            function (result) {
                angular.forEach(fleetFactory.vehicles, function (vehicle, index) {
                    if (vehicle.Checked) {

                        var object = new VehicleCollection();
                        object.Vehicle = vehicle;
                        object.Collection = collection

                        VehicleCollection.save(
                        object,
                        function (result) {
                            //Success
                            callback();
                        },
                        function (result) {
                            //Failed
                            callback();
                        });
                    }
                });
                //Success
                callback();
            },
            function (result) {
                //Failed
                callback();
            });
    };

    fleetFactory.getVehicleCollections = function (collection, callback) {
        VehicleCollection.getByCollection(
            { collection: collection.Id },
            function (result) {
                callback(result);
            },
            function (result) {
                callback(null);
            });
    };

    return fleetFactory;
});