@extends('fe-layout.main.app')

@section('title', 'Forgot Password')

@section('content')             
<div class="col-md-8 col-md-offset-2 col-xs-12 right-section m-top-10" data-ng-controller="forgotPasswordCtrl" id="forgotPassword">

    <div uib-alert ng-repeat="alert in $forgotPassword.$fn.$alerts" ng-class="'alert-' + (alert.type)" close="$forgotPassword.$fn.closeAlert($index)">
       <span ng-bind-html="alert.msg"></span>
    </div>

    <div class="bg-inverse text-white">
        <h4> &nbsp; Forgot Password</h4>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
             <div class="panel panel-default solid-corner">
                <div class="panel-body">
                    <div class="m-left-5" ng-if="$forgotPassword.$variable.success">
                        <h2 class="text-success m-top-5"><i class="fa fa-check-circle-o"></i> Success</h2>
                        <p class="f-18">
                        Reset Password Email has been sent to your email inbox. Please check the reset password email that we sent in your email account inbox to reset your password. If you didn't receive an email, please click <strong><a href="#" ng-click="$forgotPassword.$fn.resendLink($forgotPassword.$field.email)">resend reset password email link</a></strong> to receive another email. 
                        </p>    
                    </div>
                    <form class="form-horizontal m-top-10" novalidate=""  name="Form" ng-submit="$forgotPassword.$submit(Form)" ng-if="!$forgotPassword.$variable.success">
                        <p class="f-18">We will send  you a reset password link. Please enter your email address below</p>
                        <div class="form-group" ng-class="{'has-error' : $forgotPassword.$fn.setError(Form,'email')}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" ng-model="$forgotPassword.$field.email" required>
                                <span class="help-block m-bottom-5" ng-messages="Form.email.$error" ng-if="$forgotPassword.$fn.setError(Form,'email')">
                                    <strong ng-message="required">Required Field</strong>
                                    <strong ng-message="email">Invalid Email</strong>
                                    <strong ng-message="email_not_found">Email is not registered. Please enter a registered email.</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-spinner fa-pulse fa-fw" ng-if="$forgotPassword.$variable.isLoading"></i>
                                    Send Reset Password Link
                                </button>

                                <a class="btn btn-link" href="/login">
                                    Login
                                </a>
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
    <script type="text/javascript" src="/app/fe-app/controllers/forgot-password.js"></script>
    <!-- Factory Js -->
    <script type="text/javascript" src="/app/fe-app/factories/forgot-password.js"></script>
@endsection
         