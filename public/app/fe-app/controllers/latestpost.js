'use strict';

asxTradeTalkApp.controller('latestpostCtrl', function($scope, latestpostFtry){
    
    console.log('latestpostCtrl')

    $scope.init = function(){
    	$scope.$latestpost.$init(); 
    };

    $scope.$latestpost = {
        $variable : {
        	 list : [],
             isLoaded : true
        },
        $init : function(){
        	 var self = this;
             self.$variable.isLoaded = true;
        	 latestpostFtry.get().then(function(data){
                  self.$variable.isLoaded = false;
                  self.$variable.list = data;
             });        	
        }
    };

    return $scope.init();

})