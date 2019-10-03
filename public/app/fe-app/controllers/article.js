'use strict';

asxTradeTalkApp.controller('articleCtrl', function($scope, moment, articleFtry){
        
        $scope.init = function(){
           $scope.$article.$init();
        };

        $scope.$article = {
            $variable : {
               list : []
            },
            $setActive : function($ev){
               var $withActive = $("div.list-group a.list-group-item.active");
               $withActive.removeClass('active');
               var $el = angular.element($ev.currentTarget);
               $el.addClass('active');
            },
            $init : function(){
                
                var self = this;
                articleFtry.get().then(function(data){
                           // console.log(data,"data")
                           self.$variable.list = data;
                 });
            }

        };

        return $scope.init();

})