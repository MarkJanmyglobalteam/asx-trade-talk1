@extends('fe-layout.main.app')

@section('title','ASX ShareMarket Game')

@section('content')	            
<div class="col-md-9 col-xs-12 right-section" data-ng-controller="forumCtrl" id="asx-sharemarket-game"> 
	
  <div class="bg-inverse text-white clearfix">
		<h4 class="pull-left"> &nbsp; ASX Sharemarket Game 756 posts</h4>
		<button  class="btn btn-primary btn-sm pull-right m-top-5 m-right-10 m-bottom-5" ng-click="init()">
           <i class="fa fa-refresh"></i>
    </button>
	</div>

  <div role="toolbar" class="toolbar clearfix bg-default">
      <button type="button" class="btn btn-warning btn-sm pull-left m-5" >
               Post Message
      </button>
      <div class="switch-container pull-left m-left-5">
          <span class="text" ng-class="{'bolder' : $asxShareMarketGame.$variable.list_type == 'post'}">POST LIST</span>
          <label class="switch">
            <input type="checkbox" ng-model="$asxShareMarketGame.$variable.list_type" ng-true-value="'thread'" ng-false-value="'post'" ng-change="init()">
            <span class="slider round"></span>
          </label>
          <span class="text" ng-class="{'bolder' : $asxShareMarketGame.$variable.list_type == 'thread'}">THREAD LIST</span>
      </div>
      <ul uib-pagination total-items="totalItems" ng-model="currentPage" max-size="maxSize" class="pagination-sm pull-right" boundary-links="true" force-ellipses="true"></ul>
  </div>  
  
	<div class="table-responsive">
   	<table class="table table-striped" >
  		<thead>
  			<tr>
          <th>FORUM</th>
  				<th>TAGS</th>
  				<th>THREAD SUBJECT</th>
  				<th>POSTER</th>
  				<th>VIEWS</th>
  				<th>POSTS</th>
  				<th>DATE</th>
          <th class="text-center">LAST<br/>POSTER</th>
          <th class="text-center">LAST<br/>POST</th>
  			</tr>
  		</thead>
  		<tbody data-ng-cloak>
  			<tr ng-if="!$asxShareMarketGame.$variable.isLoading && $asxShareMarketGame.$variable.list.length" ng-repeat="item in $asxShareMarketGame.$variable.list"  >
  				<td data-ng-bind="item.forum"></td>
  				<td data-ng-bind="item.tags"></td>
  				<td data-ng-bind="item.thread_subject"></td>
  				<td data-ng-bind="item.poster"></td>
  				<td data-ng-bind="item.views"></td>
          <td data-ng-bind="item.posts"></td>
          <td data-ng-bind="item.date"></td>
          <td data-ng-bind="item.last_poster"></td>
          <td data-ng-bind="item.last_post"></td>
  			</tr>
        <tr ng-if="$asxShareMarketGame.$variable.isLoading">
          <td colspan="9" class="text-center">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>  
            <span class="sr-only">Loading...</span>
          </td>
        </tr>
        <tr  ng-if="!$asxShareMarketGame.$variable.isLoading && !$asxShareMarketGame.$variable.list.length">
          <td colspan="9" class="text-center" >
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
          <button type="button" class="btn btn-warning btn-sm pull-left m-5">
                   Post Message
          </button>
          <div class="switch-container pull-left m-left-5">
              <span class="text" ng-class="{'bolder' : $asxShareMarketGame.$variable.list_type == 'post'}">POST LIST</span>
              <label class="switch">
                <input type="checkbox" ng-model="$asxShareMarketGame.$variable.list_type" ng-true-value="'thread'" ng-false-value="'post'" ng-change="init()">
                <span class="slider round"></span>
              </label>
              <span class="text" ng-class="{'bolder' : $asxShareMarketGame.$variable.list_type == 'thread'}">THREAD LIST</span>
          </div>
          <ul uib-pagination total-items="totalItems" ng-model="currentPage" max-size="maxSize" class="pagination-sm pull-right" boundary-links="true" force-ellipses="true"></ul>
    </div> 
	
  </div>

</div>
@endsection

@section('page-js')
    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/controllers/asx-sharemarket-game/forum.js"></script>
    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/factories/asx-sharemarket-game.js"></script>
@endsection
