<div class="et_admin_settings" ng-app="etApp">
    <div ng-cloak ng-controller="AdminSettingsCtrl">
        <h2>Settings</h2>
        <uib-alert ng-repeat="alert in alerts" type="{{alert.type}}">{{alert.msg}}</uib-alert>
        <uib-tabset>
            <uib-tab heading="General">
                <div ng-include="'/wp-content/plugins/easytech/templates/html/general_settings.html'"></div>
            </uib-tab>
            <uib-tab heading="Steps">
                <div ng-include="'/wp-content/plugins/easytech/templates/html/steps_settings.html'"></div>
            </uib-tab>
            <uib-tab heading="Export">
                <div ng-include="'/wp-content/plugins/easytech/templates/html/export_settings.html'"></div>
            </uib-tab>
        </uib-tabset>
        <div class="et-separate"></div>
        <button ng-click="saveSettings()" type="button" class="btn btn-success pull-right et_mt20">Save Settings</button>
    </div>
</div>