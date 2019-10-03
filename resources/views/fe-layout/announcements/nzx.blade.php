@extends('fe-layout.main.app')

@section('title','Announcements')

@section('content')	            
<div class="col-md-9 col-xs-12 right-section" data-ng-controller="nsxCtrl" id="announcement">
 
	<div class="bg-inverse text-white clearfix">
		<h4 class="pull-left"> &nbsp; Announcements</h4>
		<a data-toggle="collapse"  class="btn btn-warning btn-sm pull-right search-button" data-target="#filterSection"  ng-click="$announcement.$fn.getState()">
          {[{ $announcement.$fn.text }]} <i ng-class="{'fa fa-search' : !$announcement.$fn.isOpen, 'fa fa-times' : $announcement.$fn.isOpen }"></i>
        </a>
	</div>
  
  	<div class="collapse" id="filterSection">
  		<div class="row">
            <div class="col-md-8">
                <div class="row">
                    <label class="label-control col-md-3">Symbol:</label>
                    <div class="col-md-9">
                        <ui-select ng-model="$announcement.$variable.$selected.symbol"  theme="select2">
                            <ui-select-match  placeholder="-- Code --">
                                <span ng-bind="$select.selected.name"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="symbol in ($announcement.$variable.symbols | filter: $select.search) track by symbol.id">
                                 <div ng-bind-html=" ('<span class=\'label label-default\'>' + (symbol.abbr | highlight: $select.search) + '</span>') + ' ' + (symbol.name | strLimit : 20 | highlight: $select.search) + '&emsp;' + '<strong>' + symbol.price + '</strong>' + '&emsp;' + '<span class=\'label '+ symbol.rate_type +'\'>'+ symbol.rate +'</span>'">
                                 </div>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <label class="label-control col-md-4">Display:</label>
                    <div class="col-md-8">
                       <select class="form-control" ng-model="$announcement.$variable.$selected.display" ng-options="display as display for display in $announcement.$variable.displays" ng-disabled="!$announcement.$variable.$enabled.display">
                       </select> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-top-5">
            <div class="col-md-8">
                <div class="row">
                    <label class="label-control col-md-3">Exact Match?:</label>
                    <div class="col-md-9">
                         <div class="checkbox">
						   <label>
						   	  <input type="checkbox"  ng-model="$announcement.$variable.$selected.isMatch">
							   <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
							</label>
						</div>   
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <label class="label-control col-md-4">Filter:</label>
                    <div class="col-md-8">
                        <select class="form-control" ng-model="$announcement.$variable.$selected.filter" ng-options="filter as filter for filter in $announcement.$variable.filters" ng-disabled="!$announcement.$variable.$enabled.filter">
                        </select>       
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-top-5">
            <div class="col-md-8">
                 <div class="row">
                     <label class="label-control col-md-3">Summary:</label>
                     <div class="col-md-9">
                        <textarea class="form-control" rows="5" ng-model="$announcement.$variable.$selected.summary">
                        </textarea>
                     </div>
                 </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <label class="label-control col-md-4">Exchange:</label>
                    <div class="col-md-8">
                        <select class="form-control" ng-model="$announcement.$variable.$selected.exchange" ng-options="exchange as exchange.text for exchange in $announcement.$variable.exchanges">
                        </select>       
                    </div>
                </div>
            </div>
        </div>
         <div class="row m-top-5">
            <div class="col-md-8">
                 <div class="row">
                     <label class="label-control col-md-3">Price Sensitive:</label>
                     <div class="col-md-9">
                       <select class="form-control" ng-model="$announcement.$variable.$selected.price_sensitive" ng-options="price_sensitive as price_sensitive for price_sensitive in $announcement.$variable.price_sensitives">
                        </select>
                     </div>
                 </div>
            </div>
        </div>
        <div class="row m-top-5">
            <div class="col-md-8">
                 <div class="row">
                     <label class="label-control col-md-3">From:</label>
                     <div class="col-md-9">
                       <div class="input-group">
				          <input type="text" class="form-control" uib-datepicker-popup="{[{$announcement.$variable.format}]}" ng-model="$announcement.$variable.$selected.from" is-open="$announcement.$fn.openFrom" ng-required="true" close-text="Close" alt-input-formats="$announcement.$variable.altInputFormats" />
				          <span class="input-group-btn">
				            <button type="button" class="btn btn-default" ng-click="$announcement.$fn.openFromDatePicker()"><i class="glyphicon glyphicon-calendar"></i></button>
				          </span>
				        </div>
                     </div>
                 </div>
            </div>
        </div>
        <div class="row m-top-5">
            <div class="col-md-8">
                 <div class="row">
                     <label class="label-control col-md-3">To:</label>
                     <div class="col-md-9">
                       <div class="input-group">
				          <input type="text" class="form-control" uib-datepicker-popup="{[{$announcement.$variable.format}]}" ng-model="$announcement.$variable.$selected.to" is-open="$announcement.$fn.openTo" ng-required="true" close-text="Close" alt-input-formats="$announcement.$variable.altInputFormats" />
				          <span class="input-group-btn">
				            <button type="button" class="btn btn-default" ng-click="$announcement.$fn.openToDatePicker()"><i class="glyphicon glyphicon-calendar"></i></button>
				          </span>
				        </div>
                     </div>
                 </div>
            </div>
        </div>
        <div class="col-md-12 m-top-15 divider">
        </div>
        <div class="row m-top-15">
        	<div class="col-md-3 col-md-offset-5 m-top-10">
        		<button type="button" class="btn btn-default btn-block" ng-click="$announcement.$submit()">Search</button>
        	</div>
        </div>
  	</div>

  	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>TAGS</th>
					<th>SUMMARY</th>
					<th>RELEASE DATE</th>
					<th>DOWNLOAD<br/>(FILE SIZE)</th>
					<th style="text-align: center;">PRICE<br/> SENSITIVE</th>
					<th>VIEWS</th>
				</tr>
			</thead>
			<tbody ng-cloak>
                <tr ng-if="$announcement.$variable.isLoaded">
                  <td colspan="9" class="text-center">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>  
                    <span class="sr-only">Loading...</span>
                  </td>
                </tr>
                <tr ng-if="!$announcement.$variable.isLoaded && $announcement.$variable.list.length > 0" ng-repeat="item in $announcement.$variable.list" >
                    <td data-ng-bind="item.tags"></td>
                    <td data-ng-bind="item.summary"></td>
                    <td data-ng-bind="item.release_date"></td>
                    <td data-ng-bind="item.download"></td>
                    <td data-ng-bind="item.price_sensitive"></td>
                    <td data-ng-bind="item.views"></td>
                </tr>
                <tr ng-if="!$announcement.$variable.isLoaded && $announcement.$variable.list.length === 0">
                  <td colspan="9" class="text-center">
                    <span class="fa-stack fa-lg">
                      <i class="fa fa-database fa-stack-1x"></i>
                      <i class="fa fa-ban fa-stack-2x text-danger"></i>
                    </span>
                    No Record Found.
                  </td>
                </tr>
            </tbody>
		</table>
		<div role="toolbar" class="toolbar clearfix bg-default">
				<button type="button" class="btn btn-warning btn-sm pull-left m-5" ng-click="init()">
						 <i class="fa fa-refresh"></i>
					</button>
				<ul uib-pagination total-items="totalItems" ng-model="currentPage" max-size="maxSize" class="pagination-sm pull-right" boundary-links="true" force-ellipses="true"></ul>
	    </div>	
 	</div>
</div>
@endsection

@section('page-js')
    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/controllers/announcement/nzx.js"></script>
    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/factories/announcement.js"></script>
@endsection
