angular.module('etApp', ['ui.bootstrap', 'ngSanitize', 'ngAnimate'])
    .factory('ajaxHelper', ['$http', function($http){
        return {
            request: function(action, data) {
                data = data || {};
                data.action = action;
                return $http({
                    url: ajaxUrl,
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    transformRequest: function(obj) {
                        var serialize = function(obj, prefix) {
                            var str = [];
                            for(var p in obj) {
                                if (obj.hasOwnProperty(p)) {
                                    var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
                                    str.push(typeof v == "object" ?
                                        serialize(v, k) :
                                    encodeURIComponent(k) + "=" + encodeURIComponent(v));
                                }
                            }
                            return str.join("&");
                        }
                        return serialize(obj);
                    },
                    data: data,
                }).then(function(response){
                    return response;
                });
            }
        };
    }])
    .controller('AdminSettingsCtrl', ['$scope', '$uibModal', '$http', '$timeout', 'ajaxHelper', function($scope, $uibModal, $http, $timeout, ajaxHelper){
        $scope.steps = [];
        $scope.pages = [];
        ajaxHelper.request('et_get_settings', {}).then(function(response){
            if (response.status == 200) {
                $scope.steps = response.data && response.data !== 'false' ? response.data : [];
            }
        })
        ajaxHelper.request('et_get_main_page', {}).then(function(response){
            if (response.status == 200) {
                $scope.pageTemplate = response.data && response.data !== 'false' ? response.data : "";
            }
        })
        ajaxHelper.request('et_get_pages', {}).then(function(response){
            if (response.status == 200) {
                $scope.pages = response.data && response.data !== 'false' ? response.data : [];
            }
        })
        $scope.alerts = [];

        $scope.saveTemplate = function(){
            ajaxHelper.request('et_set_main_page', {'pageSettings': $scope.pageTemplate}).then(function(response){
                if (response.status == 200) {
                    $scope.alerts.push({
                        type: "success",
                        msg: "Saved",
                    })
                    $timeout(function(){
                        $scope.alerts.splice($scope.alerts.length - 1, 1);
                    }, 1500);
                }
            })
        };

        $scope.addStep = function(){
            var modalInstance = $uibModal.open({
                animation:      true,
                windowClass:    'et_add_step_modal',
                size:           'md',
                templateUrl:    '/wp-content/plugins/easytech/templates/add_step_modal.html',
                controller: function($scope, $timeout, steps){
                    $scope.stepData = {};
                    $scope.addStep = function(){
                        steps.push($scope.stepData);
                        modalInstance.dismiss('cancel');
                    };
                },
                resolve: {
                    steps: function() {
                        return $scope.steps;
                    },
                },
            });
        }
        $scope.removeStep = function($index){
            $scope.steps.splice($index, 1);
        };

        $scope.saveStepSettings = function(){
            var promise = ajaxHelper.request('et_add_save_step_settings', {'stepsSettings': $scope.steps});
            promise.then(function(response){
                if (response.status !== 200) {

                } else {
                    $scope.alerts.push({
                        type: "success",
                        msg: "Saved",
                    })
                }
                $timeout(function(){
                    $scope.alerts.splice($scope.alerts.length - 1, 1);
                }, 1500);
            })
        };
    }])
;