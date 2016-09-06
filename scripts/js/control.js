/**
 * Created by Haus-IT on 7/6/2016.
 */
var app = angular.module('myApp',['ui.bootstrap','ngAnimate','angular.filter']);

// fetching routers and switches

app.controller('routerController',function ($scope,$http, $uibModal, $log) {

    $http.get('../server/fetchrouters.php').then(function (response) {
        $scope.entries = response.data.records;
        $scope.animationsEnabled = true;
        $scope.open = function(size){

            $scope.items = this.entry;



            var modalInstance = $uibModal.open({
                animation: $scope.animationsEnabled,
                templateUrl: 'routerupdate.html',
                controller: 'routerModalInstanceCtrl',
                size: size,
                resolve: {
                    items: function () {
                        return $scope.items;
                    }
                }
            });

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };

        $scope.toggleAnimation = function () {
            $scope.animationsEnabled = !$scope.animationsEnabled;
        };
    })


});
app.controller('routerModalInstanceCtrl', function ($scope, $uibModalInstance, items) {

    $scope.items = items;


    $scope.ok = function () {
        $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('switchController',function ($scope,$http,  $uibModal, $log) {

    $http.get('../server/fetchswitches.php').then(function (response) {
        $scope.entries = response.data.records;
        $scope.animationsEnabled = true;
        $scope.open = function(size){

            $scope.items = this.entry;



            var modalInstance = $uibModal.open({
                animation: $scope.animationsEnabled,
                templateUrl: 'switchesupdate.html',
                controller: 'switchModalInstanceCtrl',
                size: size,
                resolve: {
                    items: function () {
                        return $scope.items;
                    }
                }
            });

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };

        $scope.toggleAnimation = function () {
            $scope.animationsEnabled = !$scope.animationsEnabled;
        };
    })


});
app.controller('switchModalInstanceCtrl', function ($scope, $uibModalInstance, items) {

    $scope.items = items;


    $scope.ok = function () {
        $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

//Patching :- New, View and update

app.controller('switchpatchingController',function ($scope,$http, $uibModal, $log) {

    $http.get('../server/patchbasic.php').then(function (response) {
        $scope.floors = response.data.floors;

    })

    $http.get('../server/patchbasic2.php').then(function (response) {
        $scope.room = response.data.room;
    })
    $http.get('../server/patchbasic3.php').then(function (response) {
        $scope.switch = response.data.switch;

    })



    $http.get('../server/fetchpatch.php').then(function (response) {
        $scope.entries = response.data.records;

        $scope.animationsEnabled = true;
        $scope.open = function(size){

            $scope.items = this.entry;
            


            var modalInstance = $uibModal.open({
                animation: $scope.animationsEnabled,
                templateUrl: 'pubmodmodal.html',
                controller: 'ModalInstanceCtrl',
                size: size,
                resolve: {
                    items: function () {
                        return $scope.items;
                    }
                }
            });

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };

        $scope.toggleAnimation = function () {
            $scope.animationsEnabled = !$scope.animationsEnabled;
        };

    })
});
app.controller('ModalInstanceCtrl', function ($scope, $uibModalInstance, items) {

    $scope.items = items;


    $scope.ok = function () {
        $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});
// data for patching new page - for the dropdowns
app.controller('patchingbasicController',function ($scope,$http) {

    $http.get('../server/patchbasic.php').then(function (response) {
        $scope.floors = response.data.floors;

    })
    $http.get('../server/patchbasic2.php').then(function (response) {
        $scope.room = response.data.room;
    })
    $http.get('../server/patchbasic3.php').then(function (response) {
        $scope.switch = response.data.switch;

    })
});


