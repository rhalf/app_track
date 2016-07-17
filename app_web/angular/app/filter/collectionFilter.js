var app = angular.module('app');

app.filter('collectionFilter', function () {
    return function (array, collectionIds) {
        
        if (!collectionIds || collectionIds.length == 0) {
            return [];
        }

        var result = [];
        angular.forEach(array, function (object1) {
            angular.forEach(collectionIds, function (object2) {
                if (object1.Id === object2.Vehicle) {
                    result.push(object1);
                }
            });
        });
        return result;
    }
});