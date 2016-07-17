var app = angular.module('app');


app.controller('panelLeftController', function (
    $scope,

    authFactory,
    flagFactory,
    uiFactory,

    Collection,
    VehicleCollection,
    Vehicle,
    Driver,
    Unit,
    Sim


    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        Vehicle.query(function (vehicles) {

            $scope.vehicles = vehicles;
            angular.forEach($scope.vehicles, function (vehicle, index) {
                vehicle.Driver = Driver.get({ id: vehicle.Driver });
                Unit.get(
                     { id: vehicle.Unit },
                     function (unit) {
                         vehicle.Unit = unit;
                         vehicle.Unit.Sim = Sim.get({ id: unit.Sim });
                     });
            });

            Collection.getByCompany(
                  { company: $scope.authCompany.Id },
                  function (collections) {
                      $scope.collections = collections;

                      angular.forEach($scope.collections, function (collection, index) {
                          VehicleCollection.getByCollection(
                              { collection: collection.Id },
                              function (ids) {
                                  collection.items = [];

                                  angular.forEach($scope.vehicles, function (object1) {
                                      angular.forEach(ids, function (object2) {
                                          if (object1.Id === object2.Vehicle) {
                                              collection.items.push(object1);
                                          }
                                      });
                                  });

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



    $scope.init();
});