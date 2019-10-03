'use strict';

asxTradeTalkApp.controller('searchCtrl', function($scope, mainFtry, userList, $rootScope, $window, store){
  
 
  $rootScope.isDoneSearching = true;
  
  $scope.category = 'all';

  $scope.symbolList = [];
  mainFtry.getSymbolList().then(function(data){
      $scope.symbolList = data;
  })

  console.log($scope.symbolList,"symbolList")

  $scope.userList = [];
  userList.$loaded().then(function(data){
      $scope.userList = data;
  })

  $scope.empty = {

  };

  $scope.pagination = {
      symbol : {
        currentPage : 1,
        startWith : 0,
        setPage : function(){
            var self = this;
            var lastIndex = this.currentPage * 10;
            var startIndex = lastIndex - 10;
            self.startWith = startIndex;
        }
      },
      user : {
        currentPage : 1,
        startWith : 0,
        setPage : function(){
            var self = this;
            var lastIndex = this.currentPage * 10;
            var startIndex = lastIndex - 10;
            self.startWith = startIndex;
        }
      }
  };

  $scope.setCategory = function(category){
    $scope.category = category;
  };

  var getUrlParameter = function(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
  };

  let query = getUrlParameter('query');
  let atSymbol = query.charAt(0);
  if(atSymbol === "$"){
     	 $scope.category = 'stock';
  }else if(atSymbol === "@"){
     $scope.category = 'people';
  }else{
 	 $scope.category = 'all';
  }
  $scope.searchString = query;
  $scope.searchFnc(query);

  $scope.searchFnc = function(searchStr){
     $scope.searchKey = searchStr.charAt(0);
     if($scope.searchKey === "$"){
     	 $scope.category = 'stock';
  	 }else if($scope.searchKey === "@"){
  	   $scope.category = 'people';
  	 }else{
  	 	 $scope.category = 'all';
  	 }
  };

  
  $scope.filters = { 
        users : function(item){
          if($scope.searchKey === "@" || $scope.searchKey !== "$"){
              var $searchTxt = $scope.searchString;
              if($scope.searchKey === "@"){
                $searchTxt = $searchTxt.substring(1);
              }
              var $firstname = item.firstname.toLowerCase();
              var $lastname = item.lastname.toLowerCase();
              if($searchTxt){
                  $searchTxt = $searchTxt.toLowerCase();
                  var fullDetails = $firstname + " " + $lastname;
                  if(fullDetails.match($searchTxt)){

                      return true;
                  }
                  return false;
              }
              return true;
          }
       },
       symbols : function(item){
          if($scope.searchKey === "$" || $scope.searchKey !== "@"){
            var $searchTxt = $scope.searchString;
            if($scope.searchKey === "$"){
                $searchTxt = $searchTxt.substring(1);
            }
            var $symbol = item.symbol.toLowerCase();
            if($searchTxt){
                $searchTxt = $searchTxt.toLowerCase();
                if($symbol.match($searchTxt)){

                    return true;
                }
                return false;
            }
            return true;
          }
       }
  }

  $scope.gotoSymbol = function(symbol){
     let symbolData = { name : symbol.name, symbol : symbol.symbol, sector : symbol.sector};
     store.set('symbolData', symbolData);
     $window.location.href = "/stock/symbol/" + symbol.symbol;
  };

  $scope.gotoUser = function(user){
     let userData = user;
     store.set("userData", userData);
     $window.location.href = "/users/" + userData.firstname + userData.lastname; 
  };

});