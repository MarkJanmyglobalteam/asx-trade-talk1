@extends('fe-layout.main.app')

@section('title', 'Login')

@section('content')

<div class="col-md-12 col-xs-12" id="login" data-ng-controller="loginCtrl">

    <div class="col-md-9 hidden-sm hidden-xs column-left">
        <h1>Australian Stock Market Trade Talk</h1>
    </div>
    <div class="col-md-3 col-md-offset-0 col-sm-12  col-xs-12 column-right">
        
        <div class="row">
            <div class="col-md-12 Asx-title">
                <img src="/img/logo/asm_logo.png">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xs-12">
             <div class="panel panel-default ">
                <div class="panel-body">
                    <form class="form-horizontal m-top-10" novalidate=""  name="Form" ng-submit="$login.$submit(Form)" >
                       
                        <div class="form-group" ng-class="{'has-error' : $login.$fn.setError(Form,'email')}">
                           <!--  <label for="email" class="col-md-4 control-label">E-Mail Address</label> -->

                            <div class="col-md-12 col-xs-12">
                                <input placeholder="Email" id="email" type="email" class="form-control form-inputs" name="email" ng-model="$login.$field.email" ng-change="$login.$fn.resetEmailError(Form)" required>
                                <span class="help-block" ng-messages="Form.email.$error" ng-if="$login.$fn.setError(Form,'email')">
                                    <strong ng-message="required">Required Field</strong>
                                    <strong ng-message="email">Invalid Email</strong>
                                    <strong ng-message="no_account_found" ng-bind="$login.$variable.no_account_found"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group" ng-class="{'has-error' : $login.$fn.setError(Form,'password')}">
                           <!--  <label for="password" class="col-md-4 control-label">Password</label> -->

                            <div class="col-md-12 col-xs-12">
                                <input id="password" type="password" class="form-control form-inputs" placeholder="Password" name="password" ng-model="$login.$field.password" required>  
                                <span class="help-block" ng-messages="Form.password.$error" ng-if="$login.$fn.setError(Form,'password')">
                                        <strong ng-message="required">Required Field</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group login-button">
                            <div class="col-md-12 col-xs-12">
                                <button type="submit" class="btn btn-primary col-md-12 col-xs-12">
                                    <i class="fa fa-spinner fa-pulse fa-fw" ng-if="$login.$variable.isLoading"></i>
                                     Login
                                </button>
                            </div>
                            <div class="col-md-12 col-xs-12 forgot">
                                    <a class="btn btn-link" ng-click="$login.$fn.openReset();">
                                        Forgot Your Password?
                                    </a>
                            </div>
                            <div class="col-md-12 col-xs-12 text-center bg-gray p-bottom-20">
                                 <p>With your social media account</p>
                                 <a class="btn btn-block btn-social btn-facebook" ng-click="$login.$loginWith('facebook')">
                                    <span class="fa fa-facebook"></span> 
                                    <span class="m-left-25">Sign in with Facebook</span> 
                                  </a>
                                 <a class="btn btn-block btn-social btn-twitter" ng-click="$login.$loginWith('twitter')">
                                    <span class="fa fa-twitter"></span> 
                                    <span class="m-left-25">Sign in with Twitter</span> 
                                  </a>
                                  <a class="btn btn-block btn-social btn-google" ng-click="$login.$loginWith('google')">
                                    <span class="fa fa-google" style="top:-2px"></span> 
                                    <span class="m-left-25">Sign in with Google</span> 
                                  </a>
                            </div>
                        </div>
                        <div class="form-group forgot">
                            <div class="col-md-12 col-xs-12">
                                <a class="btn btn-link" ng-click="$login.$fn.openSignUp();">
                                    No Account Yet? <br/> Create Account Now.
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

<!-- Sign Up Modal -->
<script type="text/ng-template" id="signupModal.html">
<form  novalidate=""  name="Form" ng-submit="$signup.$submit(Form)" ng-if="!$signup.$variable.success" id="signup">
    <div class="modal-header">
        <h3 class="modal-title" id="modal-title">Create Account</h3>
    </div>
    <div class="modal-body clearfix" id="modal-body">

            <div class="row">
                <div class="col-md-6 no-p-bottom"  ng-class="{'has-error' : $signup.$fn.setError(Form,'first_name')}">
                    <label>First Name</label>
                    <input id="first_name" type="text" class="form-control" name="first_name" ng-model="$signup.$field.first_name"  required autofocus>
                    <span class="help-block no-m-bottom" ng-messages="Form.first_name.$error" ng-if="$signup.$fn.setError(Form,'first_name')">
                        <strong ng-message="required">Required Field</strong>
                    </span> 
                </div>
                <div class="col-md-6 no-p-bottom" ng-class="{'has-error' : $signup.$fn.setError(Form,'last_name')}">
                    <label>Last Name</label>
                    <input id="last_name" type="text" class="form-control" name="last_name" ng-model="$signup.$field.last_name"  required autofocus>
                    <span class="help-block no-m-bottom" ng-messages="Form.last_name.$error" ng-if="$signup.$fn.setError(Form,'last_name')">
                        <strong ng-message="required">Required Field</strong>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 no-p-bottom" ng-class="{'has-error' : $signup.$fn.setError(Form,'address')}">
                    <label>Address</label>
                    <input id="address" type="text" class="form-control" name="address" ng-model="$signup.$field.address"  required autofocus>
                    <span class="help-block no-m-bottom" ng-messages="Form.address.$error" ng-if="$signup.$fn.setError(Form,'address')">
                        <strong ng-message="required">Required Field</strong>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 no-p-bottom" ng-class="{'has-error' : $signup.$fn.setError(Form,'email')}">
                    <label>Email Address</label>
                    <input id="email" type="email" class="form-control" name="email" ng-model="$signup.$field.email"  required>
                    <span class="help-block no-m-bottom" ng-messages="Form.email.$error" ng-if="$signup.$fn.setError(Form,'email')">
                        <strong ng-message="required">Required Field</strong>
                        <strong ng-message="email">Invalid Email</strong>
                        <strong ng-message="existed">Email Address already in used.</strong>
                    </span>
                </div>
            </div>  

             <div class="row">
                <div class="col-md-6 no-p-bottom"  ng-class="{'has-error' : $signup.$fn.setError(Form,'password')}">
                    <label>Password</label>
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
                <div class="col-md-6 no-p-bottom" ng-class="{'has-error' : $signup.$fn.setError(Form,'retype')}">
                    <label>Retype Password</label>
                    <input id="retype" type="password" class="form-control" name="retype" ng-model="$signup.$field.retype" ng-change="$signup.$fn.isMatch(Form, $signup.$field)" required>  
                    <span class="help-block no-m-bottom" ng-messages="Form.retype.$error" ng-if="$signup.$fn.setError(Form,'retype')">
                            <strong ng-message="required">Required Field</strong>
                            <strong ng-message="mistmatched">Password Mismatch</strong>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 no-p-bottom">
                    <label>Photo</label>
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
    </div>
    <div class="modal-footer">
        <button class="btn btn-default" type="button" ng-click="$signup.$fn.closeModal()">Close</button>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-spinner fa-pulse fa-fw" ng-if="$signup.$variable.isLoading"></i>
            Register
        </button>
    </div>
</form>
</script>


<!-- Reset Password Modal -->
<script type="text/ng-template" id="resetPwordModal.html">
   <div class="modal-header">
        <h3 class="modal-title" id="modal-title">Reset Password</h3>
    </div>
    <div class="modal-body clearfix" id="modal-body">
          
            <div class="row">
                <div class="col-md-12 no-p-bottom" id="emailEl">
                    <label>Enter Email Address</label>
                    <input type="text" class="form-control" name="emailaddress" ng-model="emailaddress">
                </div>
            </div>      
    </div>
    <div class="modal-footer">
        <button class="btn btn-default" type="button" ng-click="close()">Close</button>
        <button type="button" class="btn btn-primary" ng-click="resetPword()">
           <span ng-if="isLoading">
             <i class="fa fa-spinner fa-pulse fa-fw"></i>
           </span>
           Reset Password 
        </button>
    </div>
</form>
</script>



@endsection        

@section('page-js')
    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/controllers/login.js"></script>
    <!-- Factory Js -->
    <script type="text/javascript" src="/app/fe-app/factories/login.js"></script>

    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/controllers/signup.js"></script>
    <!-- Factory Js -->
    <script type="text/javascript" src="/app/fe-app/factories/signup.js"></script>
@endsection
         