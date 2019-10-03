'use strict';
asxTradeTalkApp.controller('forgotPasswordCtrl', function($scope, forgotPasswordFtry){
	 
    $scope.init = function(){
      	   $scope.$forgotPassword.$init();
    }

	  $scope.$forgotPassword = {
	  	   $field : {
	  	   	   email : null
	  	   },
	  	   $variable : {
	  	   	   success : false,
             isLoading : false
	  	   },
	  	   $init : function(){
               var self = this;
               self.$field.email = null;
               self.$variable.success = false;
               self.$variable.isLoading = false; 
	  	   },
	  	   $submit : function(form){
              
              form.email.$setValidity('email_not_found' , true);
              if(form.$invalid){
              	 return false;
              }
               
              var self = this;
              self.$variable.isLoading = true; 
              forgotPasswordFtry.sendPasswordResetLink(self.$field).then(function(response){
              	   console.log(response,"response")
                   self.$variable.success = true;
                   self.$variable.isLoading = false; 
              }).catch(function(error){
              	  console.log(error,"error")
              	  var data = error.data;
  	              if(error.status == 500 && !data.success){
                     self.$variable.isLoading = false; 
  	                 form.email.$setValidity('email_not_found', false);
  	              }
              })

	  	   },
	  	   $fn : {
	  	   	 setError : function(form,field){
                  if(form[field].$invalid && (form[field].$dirty || form[field].$touched || form.$submitted)){
                    	return true;
                  }
                  return false;
     	  	},
     	  	$alerts:[],
     	  	resendLink : function(email){
     	  		      
                  console.log(email,"email")
                  
                  var self = this;
                  
                  self.$alerts = [
                    { type : 'info', msg : '<i class="fa fa-spinner fa-pulse fa-fw"></i> Resending Confirmation Email.'}
                  ];

                  forgotPasswordFtry.resendLink(email).then(function(response){
                  		self.$alerts = [
                            { type : 'success', msg : response.msg}
                       ];
                  }).catch(function(error){
                  		console.log(error,"error")
                  });
     	  	},
     	  	closeAlert : function(index) {
                var self = this;
                self.$alerts.splice(index, 1);
          },
	  	   }
	  } 
})