@extends('fe-layout.main.app')

@section('title','Stocks')

@section('content')	            
<div class="col-md-12 col-xs-12 right-section no-padding" data-ng-controller="stockCtrl" id="stocks">
 
	<div class="bg-inverse text-white clearfix">
		<h4 class="pull-left"> &nbsp; Stocks</h4>
	</div>
	
	<div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-12 col-xs-12" style="position: relative;">
		
			<ul class="list-group">				
				<li class="list-group-item item" ng-repeat="stock in stocks | orderBy : 'name'" ng-if="!stocks.length">
					 <div class="w-100 p-left-20 p-right-10 clearfix">
						 <span class="w-100 clearfix">
						 	<a href="#" ng-click="symbolClick(stock.symbol)" class="list-group-item-heading pull-left bolder" ng-bind="stock.symbol"></a>
						    <span class="pull-right f-20" ng-bind="stock.open"></span>
						 </span>
						 
						 <span class="w-100 clearfix">
						    <span class="list-group-item-text f-15 text-muted" ng-bind="stock.name"></span>
						    <span class="pull-right f-18" ng-class="{'rate-up-text' : stock.change >= 0,'rate-down-text' :  stock.change < 0 }" >
						    <span class="fa fa-fw" ng-class="{'fa-arrow-circle-o-up' : stock.change >= 0,'fa-arrow-circle-o-down' :  stock.change < 0 }">
						    </span>
						   	<span ng-bind="stock.change"></span>
						   	(<span ng-bind="stock.percentage"></span>)
						    </span>
						 </span>
					 </div>
					 <span class="box left primary">	
					 </span>
					 <span class="box right" ng-class="{'green' : stock.change >= 0,'red' :  stock.change < 0, 'primary' : stock.change === 'NA'}">	
					 </span>
				</li>				
			</ul>

			<div class="form-group text-center">
				<ul uib-pagination total-items="totalItems" items-per-page="itemsPerPage" ng-model="currentPage" max-size="maxSize" class="pagination-sm" ng-change="setPage()" boundary-link-numbers="true"></ul>	
			</div>
	</div>

	<div ng-if="stocks.length > 9" style=" width: 100%; height: 100%; position: absolute; top: 0; left: 0;background: #f5f5f5ab;z-index: 10;" >
		<span style="position: relative; top: 50%; left: 50%">
			<i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i>
			<span class="sr-only">Loading...</span>
		</span>
	</div>


	
</div>
@endsection

@section('page-js')
    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/controllers/stock.js"></script>
@endsection
