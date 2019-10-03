'use strict';
asxTradeTalkApp.controller('loginCtrl', function($scope, store, toastr, $uibModal, $log, $auth, $window, loginFtry, Auth, Ref, FirebaseStorageRef){
     
     $scope.init = function(){
         $scope.$login.$init();
     };

     $scope.$login = {
     	  $variable : {
              no_account_found : null,
              isLoading : false,
        },
     	  $field : {
 	  	  	  	email : null,
 	  	  	  	password : null
     	  },
     	  $init : function(){
	            var self = this;
	            self.$field.email = null;
	            self.$field.password = null;
	            self.$variable.no_account_found =null;
	            self.$variable.remember_me = false;
        },
     	  $submit : function(form){
             
     	  	    form.email.$setValidity('no_account_found', true);
     	  	
     	  	    if(form.$invalid){
     	  	        return false;	
     	  	    }
 			
       				var self = this;
       				var $credentials = {
       					email : self.$field.email,
       					password : self.$field.password
       				};
             
              self.$variable.isLoading = true; 
            
              Auth.$signInWithEmailAndPassword($credentials.email, $credentials.password)
              .then(function(firebaseUser) {
                console.log(firebaseUser, "firebaseUser")
                console.log("User created with uid: " + firebaseUser.uid)
                 self.$fn.redirectTo();
                 self.$variable.isLoading = false;
              }).catch(function(error) {
                 console.log(error,"error")
                 self.$fn.setErrorMsg(error, self, form);
              });
        },
        $loginWith : function(provider){
          
            var self = this;

            var $provider = undefined;
            if(provider === "facebook"){
                $provider = new firebase.auth.FacebookAuthProvider();
            }else if(provider === "google"){
                $provider = new firebase.auth.GoogleAuthProvider();
            }else if(provider === "twitter"){
                $provider = new firebase.auth.TwitterAuthProvider();
            } 
             
            Auth.$signInWithPopup($provider).then(function(firebaseUser) {
              
              var $user = firebaseUser.user;
              var $credential = firebaseUser.credential;
              var $displayName = $user.displayName.split(" ");

              // console.log("dsf")
              // console.log(firebase.auth().currentUser.email,"fsd");
              // var prevUser = firebase.auth().currentUser;
              // console.log( $credential,$user, firebase.auth().currentUser.passwordHash)
              // var credential = firebase.auth.FacebookAuthProvider.credential($credential.accessToken);
              // prevUser.link(firebase.auth.EmailAuthProvider.credential(credential));
                
              var userDataChild  = Ref.child('userData').child($user.uid);  
              userDataChild.once('value', function(data){
                  if(!data.val()){
                       userDataChild.set({
                            email : $user.email,
                            firstname : $displayName[0],
                            lastname : $displayName[1],
                            uid : $user.uid,
                            photoUrl : $user.photoURL,
                            address : ""
                       }).then(function(){
                            self.$variable.isLoading = false; 
                            self.$fn.redirectTo();
                       });         
                  }else{
                      self.$variable.isLoading = false; 
                      self.$fn.redirectTo();
                  }
              })
             
            }).catch(function(error) {
              console.log("Authentication failed:", error);
            });
        },
     	  $fn : {
     	  	setError : function(form,field){
                  if(form[field].$invalid && (form[field].$dirty || form[field].$touched || form.$submitted)){
                    	return true;
                  }
                  return false;
     	  	},
          setErrorMsg : function(error, self, form){
              var code = error.code;
              if(code == "auth/user-not-found" || code == "auth/wrong-password"){
                  form.email.$setValidity('no_account_found', false);
                  self.$variable.isLoading = false;
                  self.$variable.no_account_found = "We cant find an account with this credentials."; 
              }else if(code == "auth/invalid-email"){
                  form.email.$setValidity('email', false);
                  self.$variable.isLoading = false;
              }
          },
          resetEmailError : function(form){
               form.email.$setValidity('no_account_found', true);
          },
          redirectTo : function(){
              $window.location.href="/";
          },
          openSignUp : function(){
                $uibModal.open({
                  animation : true,
                  ariaLabelledBy : 'modal-title',
                  ariaDescribedBy : 'modal-body',
                  templateUrl : "signupModal.html",
                  controller : "signupCtrl",
                }).result.then(function () {
                  
                }, function () {
                  $log.info('Modal dismissed at: ' + new Date());
                });
          },
          openReset : function(){
                 $uibModal.open({
                  animation : true,
                  ariaLabelledBy : 'modal-title',
                  ariaDescribedBy : 'modal-body',
                  templateUrl : "resetPwordModal.html",
                  controller : function($scope, $uibModalInstance){

                    $scope.close = function(){
                       $uibModalInstance.dismiss('can;cel');
                    }

                    $scope.resetPword = function(){
                        
                        let email = $scope.emailaddress;
                        let emailEl = angular.element("#emailEl");
                        
                        if(!email){
                            console.log(emailEl.html(), "html")
                            emailEl.addClass("has-error");
                            return;
                        }

                        $scope.isLoading = true;

                        Auth.$sendPasswordResetEmail(email).then(function() {
                          toastr.success("Password reset email sent successfully!", "Success");
                          $scope.isLoading = false;
                          emailEl.removeClass("has-error");
                          $uibModalInstance.close();
                        }).catch(function(error) {
                          console.error("Error: ", error);
                           $scope.isLoading = false;
                           let msg = "Email not Existed.";
                           if(error.code === "auth/invalid-email")
                           {
                              msg = "Invalid Email."
                           }
                           toastr.error(msg, "Error");
                        });
                    }

                  },
                }).result.then(function () {
                   
                }, function () {
                  $log.info('Modal dismissed at: ' + new Date());
                });
          }
     	  }
     };

    return $scope.init();

})