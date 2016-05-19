<div class="et_admin_settings" ng-app="etApp">
    <div ng-cloak ng-controller="AdminSettingsCtrl">
        <uib-alert ng-repeat="alert in alerts" type="{{alert.type}}">{{alert.msg}}</uib-alert>
        <uib-tabset>
            <uib-tab heading="General">
                <div class="col-xs-4">
                    <select ng-model="pageTemplate" class="form-control">
                        <option value="">Select page</option>
                        <option ng-if="pages.length" ng-repeat="page in pages" value="{{page.ID}}">{{page.post_title}}</option>
                    </select>
                </div>
                <div class="col-xs-2">
                    <button class="btn btn-primary" type="button" ng-click="saveTemplate()">Save</button>
                </div>
            </uib-tab>
            <uib-tab heading="Steps">
                <button ng-click="addStep()" type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add Step</button>
                <button ng-click="saveStepSettings()" type="button" class="btn btn-success">Save Settings</button>
                <div class="et-step" ng-repeat="step in steps">
                    <h3>STEP {{$index + 1}}: {{step.description}}</h3>
                    <div class="col-xs-4 no-padding" ng-switch="step.type">
                        <div ng-switch-when="text">
                            <input readonly="readonly" type="text" name="{{step.name}}" placeholder="{{step.title}}" class="form-control" />
                        </div>
                        <div ng-switch-when="radio">
                            <input readonly="readonly" checked type="radio" name="{{step.name}}" /> {{step.title}}
                        </div>
                        <div ng-switch-when="checkbox">
                            <input readonly="readonly" checked type="checkbox" name="{{step.name}}" /> {{step.title}}
                        </div>
                        <div ng-switch-when="textarea">
                            <textarea name="{{step.name}}" readonly="readonly" placeholder="{{step.title}}" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <span ng-click="removeStep($index)" class="glyphicon glyphicon-remove et-remove-btn" aria-hidden="true"></span>
                    </div>
                    <div class="et-form-separate"></div>
                    <div class="clearfix"></div>
                </div>
            </uib-tab>
            <uib-tab heading="Export">
                12412412214
            </uib-tab>
        </uib-tabset>
    </div>

</div>