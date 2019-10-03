'use strict';

asxTradeTalkApp.controller('nsxCtrl', function($scope, announcementFtry){
  
  $scope.init = function(){
     $scope.$announcement.$init();
  }

  $scope.$announcement = {
    $variable : {
           symbols : [],
           displays : [ 100, 150, 200, 250, 300],
           filters : ['None'],
           exchanges : [
              { value : '1', text : 'ASX'},
              { value : '7', text : 'COMEX'},
              { value : '3', text : 'FOREX'},
              { value : '12', text : 'INDEXDB'},
              { value : '10', text : 'INDEXDJX'},
              { value : '13', text : 'INDEXFTSE'},
              { value : '14', text : 'INDEXHANGSENG'},
              { value : '22', text : 'INDEXNASDAQ'},
              { value : '9', text : 'INDEXNIKKEI'},
              { value : '11', text : 'INDEXSP'},
              { value : '27', text : 'LME'},
              { value : '28', text : 'NSXA'},
              { value : '8', text : 'NYMEX'},
              { value : '2', text : 'NZSX'},
           ],
           price_sensitives : ['Any', 'Yes', 'No'],
           $selected : {
              symbol : null,
              display : null,
              filter : null,
              exchange : null,
              price_sensitive : null,
              from : null,
              to : null,
              isMatch : null,
              summary : null,
           },
           formats : ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'],
           format : null,
           altInputFormats : ['M!/d!/yyyy'],
           $enabled : {
              display : false,
              filter : false
           },
           list : [],
           isLoaded : true,
    },
    $init : function(){
      
      var self = this;
      
      self.$variable.$selected.display = self.$variable.displays[0];
      self.$variable.$selected.filter = self.$variable.filters[0];
      self.$variable.$selected.exchange = self.$variable.exchanges[11];
      self.$variable.$selected.price_sensitive = self.$variable.price_sensitives[0];
      self.$variable.isLoaded = true;
      
      self.$variable.format = self.$variable.formats[0];

      announcementFtry.getSymbols().then(function(data){
          self.$variable.symbols = data;
      });

      announcementFtry.getAnnouncements().then(function(data){
          self.$variable.isLoaded = false;
          self.$variable.list = data;
      });

    },
    $fn : {
      isOpen : false,
      text : "Search",
      getState : function(){
           var $el = angular.element('#filterSection');
           this.isOpen = $el.is(":hidden");
           this.text = this.isOpen? "Close" : "Search";
      },
      openFrom : false,
      openFromDatePicker : function(){
           this.openFrom = true;
      },
      openTo : false,
      openToDatePicker : function(){
           this.openTo = true;
      },
    },
    $submit : function(){
        var self = this;
        var $selected = self.$variable.$selected;
        console.log($selected,"selected")
    }, 
  };

  return $scope.init();

});