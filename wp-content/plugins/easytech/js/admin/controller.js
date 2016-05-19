angular.module('etApp')
    .controller('AdminSettingsCtrl', ['$scope', '$uibModal', '$http', '$timeout', 'ajaxHelper', function($scope, $uibModal, $http, $timeout, ajaxHelper){
        $scope.data = {
            settings: {
                steps: [],
            },
            pages: [],
        };
        $scope.alerts = [];

        $scope.getFetchSettings = function(){
            ajaxHelper.request('et_get_settings', {}).then(function(response){
                if (response.status == 200) {
                    $scope.data.settings = angular.extend($scope.data.settings, response.data.settings);
                    $scope.data.pages = angular.extend($scope.data.pages, response.data.pages);
                }
            });
        };

        $scope.saveSettings = function(){
            ajaxHelper.request('et_save_settings', {'et-settings' : $scope.data.settings}).then(function(response){
                if (response.status == 200) {
                    $scope.alerts.push({
                        type: 'success',
                        msg: 'Settings have been saved.',
                    });
                    $timeout(function(){
                        $scope.alerts.splice($scope.alerts.length - 1, 1);
                    }, 1500);
                }
            });
        };

        $scope.getFetchSettings();

        //$scope.saveTemplate = function(){
        //    ajaxHelper.request('et_set_main_page', {'pageSettings': $scope.pageTemplate}).then(function(response){
        //        if (response.status == 200) {
        //            $scope.alerts.push({
        //                type: "success",
        //                msg: "Saved",
        //            })
        //            $timeout(function(){
        //                $scope.alerts.splice($scope.alerts.length - 1, 1);
        //            }, 1500);
        //        }
        //    })
        //};
        //
        $scope.addStep = function(){
            var modalInstance = $uibModal.open({
                animation:      true,
                windowClass:    'et_add_step_modal',
                size:           'md',
                templateUrl:    '/wp-content/plugins/easytech/templates/html/add_step_modal.html',
                controller: function($scope, $timeout, steps){
                    $scope.stepData = {};
                    $scope.addStep = function(){
                        steps.push($scope.stepData);
                        modalInstance.dismiss('cancel');
                    };
                },
                resolve: {
                    steps: function() {
                        return $scope.data.settings.steps;
                    },
                },
            });
        };

        $scope.removeStep = function($index){
            $scope.data.settings.steps.splice($index, 1);
        };


    }])
;