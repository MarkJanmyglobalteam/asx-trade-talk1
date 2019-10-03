@extends('fe-layout.main.app')

@section('title','Search')

@section('content')	            
<div class="col-md-12 col-xs-12 right-section no-padding" data-ng-controller="searchCtrl" id="search">
  <div class="col-md-3">
  	<input type="text" name="search" class="search-input" ng-keyup="searchFnc(searchString);" ng-model="searchString">
  </div>
  <div class="col-md-7">
  	<div class="form-group" ng-if="category === 'all' || category === 'stock'">
  	 <h4 class="title">Stock</h4>
  	 <div class="list-group">
	    <a href="#" ng-click="gotoSymbol(symbol)" class="list-group-item" ng-repeat="symbol in symbolList | filter : filters.symbols | limitTo:10:pagination.symbol.startWith">
	      <h3 class="list-group-item-heading" ng-bind="symbol.symbol"></h3>
	      <p class="list-group-item-text" ng-bind="symbol.name"></p>
	    </a>
	    <a href="#" class="list-group-item" ng-if="empty.isSymbolEmpty = (symbolList | filter : filters.symbols).length == 0"><i class="fa fa-ban"></i> No results</a>
	 </div>
	 <div class="text-center w-100">
	 	 <ul uib-pagination total-items="(symbolList | filter : filters.symbols).length" ng-model="pagination.symbol.currentPage" max-size="8" ng-change="pagination.symbol.setPage()" class="pagination-md" boundary-link-numbers="true"></ul>
	 </div>
	</div>
	<div class="form-group" ng-if="category === 'all' || category === 'people'">
  	 <h4 class="title">People</h4>
  	 <div class="list-group">
	    <a href="#" ng-click="gotoUser(user)" class="list-group-item clearfix" ng-repeat="user in userList | filter : filters.users | limitTo : 10">
	      <div class="pull-left">
          	  <img ng-src="{[{user.photoUrl}]}" class="imgCircle" />
          </div>
          <div class="pull-left" style="margin-top: 35px; margin-left: 10px;">
          	  <h3 class="list-group-item-heading" ng-bind="user.firstname + ' ' + user.lastname"></h3>
	          <p class="list-group-item-text" ng-bind="user.email"></p>
          </div>
	    </a>
	    <a href="#" class="list-group-item" ng-if="empty.isUserEmpty = (userList | filter : filters.users).length == 0"><i class="fa fa-ban"></i> No results</a>
	 </div>
	 <div class="text-center w-100">
	 	 <ul uib-pagination total-items="(userList | filter : filters.users).length" ng-model="pagination.user.currentPage" max-size="8" ng-change="pagination.user.setPage()" class="pagination-md" boundary-link-numbers="true"></ul>
	 </div>
	</div>
  </div>
  <div class="col-md-2">
	  <ul class="nav nav-pills nav-stacked">
	  	<li ng-class="{'active' : category === 'all'}" ng-click="setCategory('all');"><a href="#">All</a></li>
	    <li ng-class="{'active' : category === 'stock'}" ng-click="setCategory('stock');" ng-if="searchKey === '$' || searchKey !== '@'"><a href="#">Stock</a></li>
	    <li ng-class="{'active' : category === 'people'}" ng-click="setCategory('people');" ng-if="searchKey === '@' || searchKey !== '$'"><a href="#">People</a></li>
	  </ul>
  </div>
	
</div>
@endsection

@section('page-js')
    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/controllers/search.js"></script>
@endsection
