'use strict';
asxTradeTalkApp.controller('resetPasswordCtrl', function($scope, resetPasswordFtry){
     
     $scope.init = function(){
         $scope.$resetPassword.$init();
     };
     
     $scope.$resetPassword = {
     	  $variable : {
     	  		success : false,
            user_id : null,
            isLoading : false
        },
        $field : {
            password : null,
 	  	  	  retype : null,
        },
     	$init : function(){
	          var self  = this;
              self.$field.password = null;
    	      self.$field.retype = null;
              self.$variable.user_id = null;
              self.$variable.isLoading = false; 
	    },
        $getUserID : function(user_id){
            console.log(user_id,"user")
            var self  = this;
            self.$variable.user_id = user_id;
        },
     	  $submit : function(form){

     	  	    if(form.$invalid){
     	  	        return false;	
     	  	    }
 			
 				var self = this;
 				var $data = {
 					  password : self.$field.password,
                      id : self.$variable.user_id
                };

                self.$variable.isLoading = true; 
 				resetPasswordFtry.resetPassword($data).then(function(response){
 						console.log(response,"response")
 						self.$variable.success = true;
                self.$init();
     				}).catch(function(error){
     						console.log(error,"error")
                self.$variable.isLoading = false; 
     				});

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
          }
     };


     return $scope.init();

})