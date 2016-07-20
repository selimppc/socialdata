<!DOCTYPE html>
<html>
<script src=<?php public_path(); ?>"/api_app_assets/js/angular.min.js"></script>
<script src=<?php public_path(); ?>"/api_app_assets/js/app.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href=<?php public_path(); ?>"/api_app_assets/css/bootstrap.min.css">

<body>
<div class="col-lg-8 col-md-8 col-sm-12">
    <div ng-app="apiCall" ng-controller="apiCallController">
        <!--<form action="" ng-submit="submit()">-->
        <label for="company">Select Company</label>
        <select id="company" name="company" ng-model="company_id">
            <option value="2">Bank of America</option>
            <option value="3">United Nations</option>
        </select><br><br>
        <label for="sm_type">Select Social Media</label>
        <select id="sm_type" name="sm_type" ng-model="sm_type_id">
            <option value="1">Google Plus</option>
            <option value="2">Facebook</option>
        </select>
        <input type="button" ng-click="submit()" value="Click to view post">
        <!--<input type="submit">-->
        <!--</form>-->
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Post</th>
                <th>Created Date</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="postDatas in postData">
                <td>{{postDatas.post}}</td>
                <td>{{postDatas.post_date}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>





<!--
For another module
@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Title</span>
                </div>
                <div class="panel-body">

                    <form class="form-horizontal" id="jq-validation-form">
                        <div class="form-group">
                            <label for="jq-validation-required" class="col-sm-3 control-label">Required</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="jq-validation-required" name="jq-validation-required" placeholder="Required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jq-validation-select" class="col-sm-3 control-label">Select Box</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="status" name="status">
                                    <option value="">Select gear...</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary">Sign in</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
-->