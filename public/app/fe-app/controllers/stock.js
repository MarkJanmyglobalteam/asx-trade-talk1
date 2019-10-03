'use strict';

asxTradeTalkApp.controller('stockCtrl', function($scope, $timeout, $filter, store, $window, moment, rx, EODSvc, mainFtry){
    
     $scope.stocks = [];
     $scope.currentPage = 1;
     $scope.itemsPerPage = 10;
     $scope.maxSize = 15;
      // symbols = ['ASX.AX', 'AJX.AX', 'ABP.AX', 'ALR.AX', 'ABL.AX', 'ABU.AX', 'AEG.AX', 'ABT.AX'];
     $scope.symbols = [
     ];

     $scope.totalItems = 0;
     mainFtry.getSymbolList().then(function(data){
         $scope.symbols = data;
         $scope.totalItems = data.length;
         $loadStocks();
     })
     
     
    var $loadStocks = function(){
       
       $scope.stocks = [];
       
       let offset = $scope.itemsPerPage * ($scope.currentPage - 1);
       let limit = offset + $scope.itemsPerPage;
           limit = ($scope.symbols.length < limit) ? $scope.symbols.length : limit;

       for (let i = offset; i < limit; i++) {

       	   let symbol = $scope.symbols[i].symbol;
       	   let name = $scope.symbols[i].name;
           //console.log(name, symbol, "name")
           EODSvc.buildQuery({
              symbol : symbol
  	       }).fetch().then(function(data){
  	             let len = $scope.stocks.length;
  	             $scope.stocks.push(data);
  	             $scope.stocks[len]['symbol'] = symbol;
  	             $scope.stocks[len]['name'] = name;
                 let percentage = (data.change/data.previousClose) * 100;
                 $scope.stocks[len]['percentage'] = !isNaN(percentage)? (Math.abs(parseFloat(percentage).toFixed(2))) + "%" : "NA";
  	       }).catch(function(error){
  	            console.log(error,"error");
  	       })
        }

   }

   $scope.setPage = function(){
   	  $loadStocks();
   }; 

   $scope.symbolClick = function(symbol){
       var symbolData = $filter('filter')($scope.symbols, { 'symbol' : symbol })[0];
       store.set('symbolData', symbolData);
       $window.location.href = "/stock/symbol/" + symbol;
   }; 

    rx.Observable.interval(900000, new rx.ScopeScheduler($scope))
      .subscribe(function () { 
           $loadStocks();
           console.log(moment(Date.now()).format("h:mm:ss a"),"time")
       });
})
 