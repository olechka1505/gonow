angular.module('etApp')
    .controller('EtMainCtrl', ['$scope', '$uibModal', '$http', '$timeout', 'ajaxHelper', 'deviceDetector', function($scope, $uibModal, $http, $timeout, ajaxHelper, deviceDetector){
        $scope.data = {
            settings: {
                steps: [],
                overriddenPage: {
                    ID: "0",
                },
            },
            requestData: {},
            pages: [],
        };
        $scope.alerts = [];
        $scope.deviceDetector = deviceDetector;

        $scope.getFetchSettings = function(){
            ajaxHelper.request('et_fetch_settings', {}).then(function(response){
                if (response.status == 200) {
                    $scope.data.settings = angular.extend($scope.data.settings, response.data.settings);
                    $scope.data.pages = angular.extend($scope.data.pages, response.data.pages);
                }
            });
        };
        $scope.getFetchSettings();

        $scope.connectSubmit = function(){
            if ($scope.ConnectForm.$valid){
                ajaxHelper.request('et_create_connect', {requestData: $scope.data.requestData}).then(function(response){
                    if (response.status == 200 && response.data.success) {
                        window.location.href = 'https://www.fastsupport.com/'
                    }
                });
            }
        };

    }])
;