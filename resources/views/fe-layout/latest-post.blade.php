	@extends('fe-layout.main.app')

@section('title', 'Latest Post')

@section('content')
<div class="col-md-9 col-xs-12 right-section" data-ng-controller="latestpostCtrl" id="latest-post">
	
	<div class="bg-inverse text-white">
		<h4> &nbsp; Latest Post</h4>
	</div>

    <div class="col-md-12 m-bottom-20 table-container">
    	<div role="toolbar" class="toolbar clearfix bg-default">
			<button type="button" class="btn btn-warning btn-sm pull-left m-5" ng-click="init()">
					 <i class="fa fa-refresh"></i>
				</button>
			<ul uib-pagination total-items="totalItems" ng-model="currentPage" max-size="maxSize" class="pagination-sm pull-right" boundary-links="true" force-ellipses="true"></ul>
	    </div>
	    <div class="col-md-12 col-table clearfix">
	    	<div class="table-responsive">
				<table class="table table-striped">
					<thead>
							<tr>
							<th style="width : 150px">FORUM</th>
							<th>TAGS</th>
							<th>SUBJECTS</th>
							<th style="width : 100px">VIEW AS</th>
							<th>POSTER</th>
							<th>VIEWS</th>
							<th>RATING</th>
							<th>DATE</th>
							</tr>
					</thead>
					<tbody ng-cloak>
						<tr class="post-title">
							<td colspan="8" align="center">
								LATEST POSTS
							</td>
						</tr>
						 <tr ng-if="$latestpost.$variable.isLoaded">
				          <td colspan="9" class="text-center">
				            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>  
				            <span class="sr-only">Loading...</span>
				          </td>
				        </tr>
						<tr ng-if="!$latestpost.$variable.isLoaded && $latestpost.$variable.list.length > 0" ng-repeat="item in $latestpost.$variable.list" >
							<td data-ng-bind="item.forum"></td>
							<td data-ng-bind="item.tags"></td>
							<td data-ng-bind="item.subject"></td>
							<td><a href="#" data-ng-bind="item.view_as"></a></td>
							<td data-ng-bind="item.poster"></td>
							<td data-ng-bind="item.views"></td>
							<td data-ng-bind="item.rating"></td>
							<td data-ng-bind="item.date"></td>
						</tr>
						<tr ng-if="!$latestpost.$variable.isLoaded && $latestpost.$variable.list.length == 0">
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
			</div>
			<div role="toolbar" class="toolbar clearfix bg-default">
				<button type="button" class="btn btn-warning btn-sm pull-left m-5" ng-click="init()">
						 <i class="fa fa-refresh"></i>
					</button>
				<ul uib-pagination total-items="totalItems" ng-model="currentPage" max-size="maxSize" class="pagination-sm pull-right" boundary-links="true" force-ellipses="true"></ul>
	    	</div>	
		</div>	
	</div>
</div>
@endsection        

@section('page-js')
    <!-- Controller JS -->
    <script type="text/javascript" src="/app/fe-app/controllers/latestpost.js"></script>
    <!-- Factory JS -->
    <script type="text/javascript" src="/app/fe-app/factories/latestpost.js"></script>
@endsection    