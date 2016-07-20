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
        company = authFactory.getCompany();

        Vehicle.query(
            function (vehicles) {
                fleetFactory.vehicles = vehicles;
                angular.forEach(fleetFactory.vehicles, function (vehicle, index) {
                    vehicle.Driver = Driver.get({ id: vehicle.Driver });
                    Unit.get(
                         { id: vehicle.Unit },
                         function (unit) {
                             vehicle.Unit = unit;
                             vehicle.Unit.Sim = Sim.get({ id: unit.Sim });
                         });
                });

                Collection.getByCompany(
                      { company: company.Id },
                      function (collections) {
                          fleetFactory.collections = collections;

                          angular.forEach(fleetFactory.collections, function (collection, index) {
                              VehicleCollection.getByCollection(
                                  { collection: collection.Id },
                                  function (vehicleCollections) {
                                      collection.vehicles = [];
                                      angular.forEach(fleetFactory.vehicles, function (vehicle) {
                                          angular.forEach(vehicleCollections, function (vehicleCollection) {
                                              if (vehicle.Id === vehicleCollection.Vehicle) {
                                                  collection.vehicles.push(vehicle);
                                              }
                                          });
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
                        object.Vehicle = vehicle.Id;
                        object.Collection = collection.Id

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