<?php
/*
Template Name: EasyTech template
*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>EasyTech</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/wp-content/plugins/easytech/css/reset.min.css" />
    <link rel="stylesheet" type="text/css" href="/wp-content/plugins/easytech/css/all.site.css" />
    <link rel="stylesheet" type="text/css" href="/wp-content/plugins/easytech/css/main.css" />
    <style type="text/css">
        body { background-color: #ECECEC; }
        #connectPageContent span.highlight { color: ;  font-size:20px;  font-weight:700; }
        #connectPageContent .connectPageColor { color: ; font-weight:700;}
    </style>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js'></script>
    <script type='text/javascript' src='https://code.angularjs.org/1.4.5/angular-animate.min.js'></script>
    <script type='text/javascript' src='https://code.angularjs.org/1.4.5/angular-sanitize.min.js'></script>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.2/ui-bootstrap.min.js'></script>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.2/ui-bootstrap-tpls.min.js'></script>

    <script type='text/javascript' src='/wp-content/plugins/easytech/js/front/re-tree.min.js'></script>
    <script type='text/javascript' src='/wp-content/plugins/easytech/js/front/ng-device-detector.min.js'></script>
    <script type='text/javascript' src='/wp-content/plugins/easytech/js/front/module.js'></script>
    <script type='text/javascript' src='/wp-content/plugins/easytech/js/front/service.js'></script>
    <script type='text/javascript' src='/wp-content/plugins/easytech/js/front/controller.js'></script>
</head>
<body ng-app="etApp">
<div id="connectPageContent" ng-controller="EtMainCtrl">
    <div class="connectSection">
        <div class="logo">
            <img src="/wp-content/plugins/easytech/images/connect_logo.gif" alt="EasyTech" align="right" style="float:right"/>
            <div>
                <br/><br/>
                <hr class="topDivider"/>
                <div class="mainDiv">
                    <div class="errorMessage" id="errorMessage">

                    </div>
                    <div>
                        <div class="machineInfo">
                            <p>
                                <span class="connectPageColor">IF ASKED..</span>
                            <div class="BrowserAndOsInfo">
                                Your Browser is <span id="browserName">{{ deviceDetector.browser }}: {{ deviceDetector.browser_version }}</span>&nbsp;and your Operating System is <span id="osName">{{ deviceDetector.os }}</span>
                            </div>
                            </p>
                        </div>
                        <div class="mainForm">
                            <?php $settings = get_option('et_settings'); ?>
                            <form novalidate method="post" name="ConnectForm" ng-submit="connectSubmit()">
                                <div class="form-row" ng-repeat="step in data.settings.steps">
                                    <div ng-switch="step.type">
                                        <div class="description"><span class="bold">STEP {{$index + 1}}:</span> {{ step.description }}</div>
                                        <div ng-switch-when="text">
                                            <input ng-required="step.is_required" ng-model="data.requestData[step.name]" type="text" name="{{step.name}}" placeholder="{{step.title}}" class="form-control" />
                                        </div>
                                        <div ng-switch-when="radio">
                                            <input ng-required="step.is_required" ng-model="data.requestData[step.name]" ng-class="{error: ConnectForm[step.name].$dirty && ConnectForm[step.name].$invalid}" readonly="readonly" checked type="radio" name="{{step.name}}" /> {{ step.title }}
                                        </div>
                                        <div ng-switch-when="checkbox">
                                            <input ng-required="step.is_required" ng-model="data.requestData[step.name]" ng-class="{error: ConnectForm[step.name].$dirty && ConnectForm[step.name].$invalid}" readonly="readonly" checked type="checkbox" name="{{step.name}}" />  {{ step.title }}
                                        </div>
                                        <div ng-switch-when="textarea">
                                            <textarea ng-required="step.is_required" ng-model="data.requestData[step.name]" ng-class="{error: ConnectForm[step.name].$dirty && ConnectForm[step.name].$invalid}" name="{{step.name}}" readonly="readonly" placeholder="{{step.title}}" class="form-control"></textarea>
                                        </div>

                                        <div ng-switch-when="custom">
                                            <div ng-bind-html="step.html"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="description"><span class="bold">STEP {{ data.settings.steps.length + 1 }}:</span> When instructed, click the Connect button. </div>
                                    <button ng-disabled="ConnectForm.$invalid" type="submit" class="btn btn-default">Connect</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>

