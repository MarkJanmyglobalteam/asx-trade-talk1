@extends('fe-layout.main.app')

@section('title', ' Reset Password')

@section('content')             
<div class="col-md-8 col-md-offset-2 col-xs-12 right-section m-top-10" data-ng-controller="resetPasswordCtrl" id="resetPassword" ng-init="$resetPassword.$getUserID('{{ $user->userid }}')">
   
    <div class="bg-inverse text-white">
        <h4> &nbsp; Reset Password</h4>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
             <div class="panel panel-default solid-corner">
                <div class="panel-body">
                    <div class="m-left-5" ng-if="$resetPassword.$variable.success">
                        <h2 class="text-success m-top-5"><i class="fa fa-check-circle-o"></i> Success</h2>
                        <p class="f-18">
                        You successfully reset you password. Please click <strong><a href="/login"">login link</a></strong> to check you updated password. 
                        </p>    
                    </div>
                    <form class="form-horizontal m-top-10" novalidate=""  name="Form" ng-submit="$resetPassword.$submit(Form)" ng-if="!$resetPassword.$variable.success">
                       
                        <div class="form-group" ng-class="{'has-error' : $resetPassword.$fn.setError(Form,'password')}">
                            <label for="password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" ng-model="$resetPassword.$field.password" ng-change="$resetPassword.$fn.isMatch(Form, $resetPassword.$field)" required>  
                                <span ng-if="$resetPassword.$field.password">
                                <label class="control-label w-100 text-right no-p-top f-12">
                                    <em class="text-light-blue" ng-if="value < 50 && value >= 0">(Weak)</em><em class="text-light-orange" ng-if="value < 83 && value >= 50">(Medium)</em><em class="text-light-green" ng-if="value >= 83">(Strong)</em>
                                </label>
                                <div ng-password-strength="$resetPassword.$field.password" strength="value" strength="passStrength" inner-class="progress-bar" inner-class-prefix="progress-bar-"></div>
                                </span>
                                <span class="help-block no-m-bottom" ng-messages="Form.password.$error" ng-if="$resetPassword.$fn.setError(Form,'password')">
                                        <strong ng-message="required">Required Field</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group" ng-class="{'has-error' : $resetPassword.$fn.setError(Form,'retype')}">
                            <label for="retype" class="col-md-4 control-label">Retype Password</label>

                            <div class="col-md-6">
                                <input id="retype" type="password" class="form-control" name="retype" ng-model="$resetPassword.$field.retype" ng-change="$resetPassword.$fn.isMatch(Form, $resetPassword.$field)" required>  
                                <span class="help-block no-m-bottom" ng-messages="Form.retype.$error" ng-if="$resetPassword.$fn.setError(Form,'retype')">
                                        <strong ng-message="required">Required Field</strong>
                                        <strong ng-message="mistmatched">Password Mismatch</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-spinner fa-pulse fa-fw" ng-if="$resetPassword.$variable.isLoading"></i>
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
         
        </div>
</div>
@endsection        

@section('page-js')
    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/controllers/reset-password.js"></script>
    <!-- Factory Js -->
    <script type="text/javascript" src="/app/fe-app/factories/reset-password.js"></script>
@endsection
         