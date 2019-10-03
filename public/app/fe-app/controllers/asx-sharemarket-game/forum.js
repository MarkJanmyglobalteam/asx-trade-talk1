'use strict';
asxTradeTalkApp.controller('forumCtrl', function($scope, $timeout, asxShareMarketGameFtry){
	  
	  $scope.init = function(){
	  	$scope.$asxShareMarketGame.$init();
	  };

	  $scope.$asxShareMarketGame = {
	  		$variable : {
	  			isLoading : true,
	  			list_type : "post",
	  			list : [],
	  		},
	  		$init : function(){
	  			 var self = this;
	  			 var $list_type = self.$variable.list_type;
	  			 self.$variable.isLoading = true;
	  			 asxShareMarketGameFtry.get($list_type).then(function(data){            
                     self.$variable.isLoading = false;
                     self.$variable.list = data;                 
                 });
	  		}
	  };

    return $scope.init();

})