@extends('fe-layout.main.app')

@section('title', 'Timeline')

@section('content')
<div class="col-md-12 col-xs-12 right-section m-top-5" data-ng-controller="streamsCtrl" id="streams">
    <div class="row">
    	<div class="col-md-3">
    		<div class="panel panel-primary solid-corner" style="width: 100%">
				  <div class="panel-heading solid-corner">TRENDING</div>
				  <div class="panel-body">
					<img src="/img/chart1.png" class="img-responsive" style="width: 100%; height: 100%;">
					<hr>

				  </div>
			</div>
    	</div>
    	<div class="col-md-5">
  		<div class="comment-section" >
  			<form ng-submit="$streams.$save()">
	  			<div class="form-group">
	  				<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-2">
							<img src="/img/user.png" class="img-responsive" id="streamNewPostImg" >
						</div>
						<div class="col-md-10 col-sm-10 col-xs-10 clearfix">
							
								 <textarea placeholder="Share your idea about stocks" class="form-control postTextArea" ng-model="$streams.$field.post" rows="4" cols="100"
								 ng-disabled="$streams.$variable.isPosting">
								 </textarea>
								 <label class="img-thumbnail attachFile" title="Attach File" ng-class="{'noFile bg-primary' : !$streams.$variable.file.isLoaded, 'withFile': $streams.$variable.file.isLoaded }">
			                        <input type="file" class="form-control" file-read="$streams.$variable.
			                        file" style="display:none" ng-disabled="$streams.$variable.isPosting">
			                        <i class="fa fa-line-chart fa-lg fa-fw" aria-hidden="true" ng-if="!$streams.$variable.file.isLoaded"></i>
			                        <img ng-src="{[{ $streams.$variable.
			                        file.src }]}" ng-if="$streams.$variable.
			                        file.isLoaded && $streams.$variable.file.fileType == 'image'" class="imgFilePreview">
			                        <video ng-src="{[{ $streams.$variable.
			                        file.src }]}" ng-if="$streams.$variable.
			                        file.isLoaded && $streams.$variable.file.fileType == 'video'" class="videoFilePreview">
									    Your browser does not support HTML5 video.
									</video>
			                        <i class="fa fa-times-circle fa-fw" style="position: absolute; top: -6px; right: -11px; font-size: 18px;" ng-if="$streams.$variable.
			                        file.isLoaded" ng-click="$streams.$closeImage($event)"></i>
			                    </label>
					  			<button type="submit" class="pull-right m-top-5 shareButton" ng-disabled="$streams.$variable.isPosting">
					  				<span ng-if="$streams.$variable.isPosting">
						  				<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>
						  				Posting
					  				</span>
					  				<span ng-if="!$streams.$variable.isPosting">
					  					Share
					  				</span> 
					  			</button>
					  	</div>
				    </div>
	  			</div>
	  		</form>
		</div>
		
		<hr>
		<div class="row">
		<img src="/img/user.png" style="width: 60px; height: 60px;" align="left" >
			<h4 id="service-desc"><a href="#" style="text-decoration: none;">Mark Jan Vincent Enriquez</a><br>
			Nam vel fermentum mi. Donec posuere hendrerit dolor, id auctor justo tristique eu. Sed et porttitor risus. </h4>
			<div>
				<img src="/img/chart1.png" class="img-responsive" style="width: 85%; height: 90%; float: right;">
			</div>
			<div class="icon-bar" align="right" style="padding-top: 10px; margin-right: 40px; float: right;">
				 <span class="glyphicon glyphicon-comment" style="margin-right: 15px;font-size: 17px; color:#4F79AD;"></span>
				 <span class="glyphicon glyphicon-share" style="margin-right: 15px;font-size: 17px; color:#4F79AD;"></span>
				 <span class="glyphicon glyphicon-thumbs-up" style="margin-right: 15px;font-size: 17px; color:#4F79AD;" ></span>
				 <span class="glyphicon glyphicon-option-horizontal" style="margin-right: 15px; font-size: 17px; color:#4F79AD;"></span>
			</div>
		</div>
  </div>

</div>	 
</div>
@endsection        

@section('page-js')
<!-- Controller JS -->
<script type="text/javascript" src="/app/fe-app/controllers/streams.js"></script>
<!-- Factory Js -->
<script type="text/javascript" src="/app/fe-app/factories/streams.js"></script>

@endsection

