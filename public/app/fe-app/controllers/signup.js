'use strict';
asxTradeTalkApp.controller('signupCtrl', function($scope, $rootScope, signupFtry, Auth, Ref, FirebaseStorageRef, $window, $uibModalInstance){
     
     $scope.init = function(){
         $scope.$signup.$init();
     };

     $rootScope.isSigningUp = true;
     
     $scope.$signup = {
     	  $variable : {
     	  		success : false,
            user_id : 1,
            isLoading : false,
            file : { isLoaded : null},
     	  },
          $field : {
              first_name : null,
              last_name : null,
 	  	  	  	email : null,
 	  	  	  	password : null,
 	  	  	  	retype : null
     	  },
     	  $init : function(){
	            var self = this;
	            self.$field.first_name = null;
	            self.$field.last_name = null;
	            self.$field.email = null;
              self.$field.address = null;
	            self.$field.password = null;
	            self.$field.retype = null;
              self.$variable.isLoading = false;
              self.$variable.file = { isLoaded : null};
	      },
     	  $submit : function(form){

                form.email.$setValidity('existed', true);

                if(form.$invalid){
     	  	        return false;	
     	  	       }
                
                var self = this;
                self.$variable.isLoading = true; 
                self.$saveUser(form);
 			
 				

 		  },
      $saveUser : function(form){
                
                var self = this;
                var $data = {
                    first_name : self.$field.first_name,
                    last_name : self.$field.last_name,
                    email : self.$field.email,
                    address : self.$field.address,
                    password : self.$field.password
                };

                var $defaultPic = "https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg";
               
                Auth.$createUserWithEmailAndPassword($data.email, $data.password)
                .then(function(firebaseUser) {
                   
                    Ref.child('userData').child(firebaseUser.uid).set({
                        email : $data.email,
                        firstname : $data.first_name,
                        lastname : $data.last_name,
                        address : $data.address,
                        uid : firebaseUser.uid,
                        photoUrl : $defaultPic,
                    }).then(function(){
                        self.$savePhoto(firebaseUser.uid);
                    });

                }).catch(function(error) {
                    self.$variable.isLoading = false; 
                    var $code = error.code;
                    var $msg = error.message;
                    if($code == "auth/email-already-in-use" && $msg){
                         form.email.$setValidity('existed', false);
                    }else if($code == "auth/invalid-email" && $msg){
                         form.email.$setValidity('email', false);
                    }
                    console.log(error,"error")
                });
          },
          $savePhoto : function(uid){
                
                var self = this;
                var $file = self.$variable.file.data;
                if($file){
                    var $filesRef = FirebaseStorageRef.child('profileimages').child(uid);
                    var $uploadTask = $filesRef.put($file);
                    $uploadTask.on('state_changed', function(snapshot){
                      // Observe state change events such as progress, pause, and resume
                      // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
                      var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                      console.log('Upload is ' + progress + '% done');
                      switch (snapshot.state) {
                        case firebase.storage.TaskState.PAUSED: // or 'paused'
                          console.log('Upload is paused');
                          break;
                        case firebase.storage.TaskState.RUNNING: // or 'running'
                          console.log('Upload is running');
                          break;
                      }
                    }, function(error) {
                      // Handle unsuccessful uploads
                      
                      // A full list of error codes is available at
                      // https://firebase.google.com/docs/storage/web/handle-errors
                      switch (error.code) {
                        case 'storage/unauthorized':
                          // User doesn't have permission to access the object
                          break;

                        case 'storage/canceled':
                          // User canceled the upload
                          break;

                        case 'storage/unknown':
                          // Unknown error occurred, inspect error.serverResponse
                          break;
                      }

                       self.$variable.isLoading = false; 

                    }, function() {
                      // Handle successful uploads on complete
                      // For instance, get the download URL: https://firebasestorage.googleapis.com/...
                       var downloadURL = $uploadTask.snapshot.downloadURL;
                       Ref.child('userData').child(uid).update({
                         photoUrl : downloadURL,
                       }).then(function(){
                          self.$variable.isLoading = false; 
                          $rootScope.isSigningUp = false;
                          $window.location.href = "/";
                       });
                     
                    });

                }else{
                     self.$variable.isLoading = false; 
                     $window.location.href = "/";
                     $rootScope.isSigningUp = false;
                }

          },
     	  $fn : {
     	  	setError : function(form, field){
                  if(form[field].$invalid && (form[field].$dirty || form[field].$touched || form.$submitted)){
                  		return true;
                  }

                  return false;
     	  	},
        	isMatch: function(form,field){
     	  		var $isMatch = true;
                if((field.retype && field.password) && (field.retype != field.password)){
                	$isMatch = false;
                }
                form.retype.$setValidity('mistmatched', $isMatch)
     	  	},
          closeModal : function(){
              $uibModalInstance.dismiss('cancel');
          }
     	  }
     };


     return $scope.init();

})