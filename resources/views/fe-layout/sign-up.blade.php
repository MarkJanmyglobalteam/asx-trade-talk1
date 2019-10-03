@extends('fe-layout.main.app')

@section('title', 'Sign-Up')

@section('content')             
<div class="col-md-8 col-md-offset-2 col-md-8 col-sm-8 col-xs-12 right-section m-top-10" data-ng-controller="signupCtrl" id="signup">
    <div class="bg-inverse">
        <h4> &nbsp; Sign Up</h4>
    </div>
    <div uib-alert ng-repeat="alert in $signup.$fn.$alerts" ng-class="'alert-' + (alert.type)" close="$signup.$fn.closeAlert($index)">
        <span ng-bind-html="alert.msg"></span>
    </div>
    

    <div class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
             <div class="panel panel-default solid-corner">
                <div class="panel-body">
                    {{-- <div class="m-left-5" ng-if="$signup.$variable.success">
                        <h2 class="text-success m-top-5"><i class="fa fa-check-circle-o"></i> Success</h2>
                        <p class="f-18">
                        You successfully created an account. Please check the confirmation email that we sent in your email account inbox to confirm your account. If you didn't receive an email, please click <strong><a href="#" ng-click="$signup.$fn.resendLink($signup.$variable.user_id)">resend email confirmation link</a></strong> to receive another confirmation email. 
                        </p>    
                    </div> --}}
                    <form class="form-horizontal m-top-10" novalidate=""  name="Form" ng-submit="$signup.$submit(Form)" ng-if="!$signup.$variable.success">
                       
                        <div class="form-group" ng-class="{'has-error' : $signup.$fn.setError(Form,'first_name')}">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6 no-p-top">
                                <input id="first_name" type="text" class="form-control" name="first_name" ng-model="$signup.$field.first_name"  required autofocus>
                                <span class="help-block no-m-bottom" ng-messages="Form.first_name.$error" ng-if="$signup.$fn.setError(Form,'first_name')">
                                    <strong ng-message="required">Required Field</strong>
                                </span>
                            </div>
                        </div> 

                        <div class="form-group" ng-class="{'has-error' : $signup.$fn.setError(Form,'last_name')}">
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6 no-p-top">
                                <input id="last_name" type="text" class="form-control" name="last_name" ng-model="$signup.$field.last_name"  required autofocus>
                                <span class="help-block no-m-bottom" ng-messages="Form.last_name.$error" ng-if="$signup.$fn.setError(Form,'last_name')">
                                    <strong ng-message="required">Required Field</strong>
                                </span>
                            </div>
                        </div>  

                        <div class="form-group" ng-class="{'has-error' : $signup.$fn.setError(Form,'address')}">
                            <label for="address" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6 no-p-top">
                                <input id="address" type="text" class="form-control" name="address" ng-model="$signup.$field.address"  required autofocus>
                                <span class="help-block no-m-bottom" ng-messages="Form.address.$error" ng-if="$signup.$fn.setError(Form,'address')">
                                    <strong ng-message="required">Required Field</strong>
                                </span>
                            </div>
                        </div>  

                        <div class="form-group" ng-class="{'has-error' : $signup.$fn.setError(Form,'email')}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6 no-p-top">
                                <input id="email" type="email" class="form-control" name="email" ng-model="$signup.$field.email"  required>
                                <span class="help-block no-m-bottom" ng-messages="Form.email.$error" ng-if="$signup.$fn.setError(Form,'email')">
                                    <strong ng-message="required">Required Field</strong>
                                    <strong ng-message="email">Invalid Email</strong>
                                    <strong ng-message="existed">Email Address already in used.</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group" ng-class="{'has-error' : $signup.$fn.setError(Form,'password')}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6 no-p-top">
                                <input id="password" type="password" class="form-control" name="password" ng-model="$signup.$field.password" ng-change="$signup.$fn.isMatch(Form, $signup.$field)" min="6" pattern=".{6,}" required>  
                                <span ng-if="$signup.$field.password">
                                <label class="control-label w-100 text-right no-p-top f-12">
                                    <em class="text-light-blue" ng-if="value < 50 && value >= 0">(Weak)</em><em class="text-light-orange" ng-if="value < 83 && value >= 50">(Medium)</em><em class="text-light-green" ng-if="value >= 83">(Strong)</em>
                                </label>
                                <div ng-password-strength="$signup.$field.password" strength="value" strength="passStrength" inner-class="progress-bar" inner-class-prefix="progress-bar-"></div>
                                </span>
                                <span class="help-block no-m-bottom" ng-messages="Form.password.$error" ng-if="$signup.$fn.setError(Form,'password')">
                                        <strong ng-message="required">Required Field</strong>
                                        <strong ng-message="pattern">Password should be at least 6 characters</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group" ng-class="{'has-error' : $signup.$fn.setError(Form,'retype')}">
                            <label for="retype" class="col-md-4 control-label">Retype Password</label>

                            <div class="col-md-6 no-p-top">
                                <input id="retype" type="password" class="form-control" name="retype" ng-model="$signup.$field.retype" ng-change="$signup.$fn.isMatch(Form, $signup.$field)" required>  
                                <span class="help-block no-m-bottom" ng-messages="Form.retype.$error" ng-if="$signup.$fn.setError(Form,'retype')">
                                        <strong ng-message="required">Required Field</strong>
                                        <strong ng-message="mistmatched">Password Mismatch</strong>
                                </span>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label for="retype" class="col-md-4 control-label">Photo<!-- Retype Password --></label>
                            <div class="col-md-6 no-p-top">
                                <div class="input-group image-preview">
                                    <input placeholder="" type="text" class="form-control image-preview-filename" disabled="disabled" ng-model="$signup.$variable.file.data.name">
                                    <!-- don't give a name === doesn't send on POST/GET --> 
                                    <span class="input-group-btn"> 
                                  
                                    <!-- image-preview-input -->
                                    <div class="btn btn-default image-preview-input"> <span class="glyphicon glyphicon-folder-open"></span> <span class="image-preview-input-title">Browse</span>
                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="input-file-preview" file-read="$signup.$variable.file"/>
                                        <!-- rename it --> 
                                    </div>
                                   
                                    </span> 
                                </div>
                                <!-- /input-group image-preview [TO HERE]--> 
                               <div class="w-100 img-thumbnail m-top-5" ng-if="$signup.$variable.
                                    file.isLoaded">
                                    <img ng-src="{[{ $signup.$variable.
                                    file.src }]}" ng-if="$signup.$variable.file.fileType == 'image'" class="img-responsive" style="margin:auto;" />
                               </div>
                            </div>
                        </div>
                     

                        <div class="form-group">
                            <label for="retype" class="col-md-2 control-label"></label>
                            <div class="col-md-6 col-md-offset-2">
                                <button type="button" ng-click="$signup.$init()" class="btn btn-default">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-spinner fa-pulse fa-fw" ng-if="$signup.$variable.isLoading"></i>
                                    Register
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
    <script type="text/javascript" src="/app/fe-app/controllers/signup.js"></script>
    <!-- Factory Js -->
    <script type="text/javascript" src="/app/fe-app/factories/signup.js"></script>
@endsection
         