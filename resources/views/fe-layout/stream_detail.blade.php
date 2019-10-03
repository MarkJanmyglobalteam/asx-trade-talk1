@extends('fe-layout.main.app')

@section('title', 'Streams')

@section('content')
<div class="col-md-12 col-xs-12 right-section m-top-5" data-ng-controller="streamDetailCtrl" id="streams">
    <div class="row">
    	<div class="col-md-5 col-md-offset-3">
  		                    
     <!-- start -->
      <div class="row">
       <div class="col-xs-12 col-sm-12 no-p-top no-p-bottom">
            <div class="panel panel-default panel-google-plus">
                <!-- <div class="dropdown">
                    <span class="dropdown-toggle" type="button" data-toggle="dropdown"></span>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Edit Post</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Share Post</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Report TradeTalk for abuse</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Delete Post</a></li>
                    </ul>
                </div> -->
                <!-- <div class="panel-google-plus-tags">
                    <ul>
                        <li>#BTC</li>
                        <li>#ASX</li>
                    </ul>
                </div> -->
                <div class="panel-heading">
                    <img class="img-circle pull-left img-responsive" ng-src="{[{ stream.userInfo.photo }]}" alt="profile_photo" style="width : 50px; height: 50px;border: 2px solid #337ab7" popover-trigger="'outsideClick'" uib-popover-template="'post_profile.html'" popover-placement="right-top" />
                    <h3 ng-bind="stream.userInfo.fullname" class="hand" ng-click="mentionClick(stream.uid)"></h3>
                    <script type="text/ng-template" id="post_profile.html">
                        <div class="form-group text-center">
                            <img class="img-circle img-responsive pop-up-profile" ng-src="{[{ stream.userInfo.photo }]}" alt='profilePhoto'>
                        </div>
                        <div class="form-group text-center">
                                 <p class="lead no-m-bottom hand" ng-click="mentionClick(stream.uid)" data-ng-bind="stream.userInfo.fullname"></p>
                                 <p class="text-primary" data-ng-bind="stream.userInfo.email"></p>
                                 <button class="btn btn-primary btn-rounded btn-block m-top-10 f-18" ng-click="followUser(stream.uid)" ng-if=" !checkIfAlreadyFollowed(stream.uid, authenticatedUser.uid) && authenticatedUser.uid != stream.uid">Follow</button>
                                 <button class="btn btn-primary btn-rounded btn-block m-top-10 f-18" ng-click="unFollowUser(stream.uid)" ng-if="checkIfAlreadyFollowed(stream.uid, authenticatedUser.uid) && authenticatedUser.uid != stream.uid">Unfollow</button>
                        </div>
                    </script>
                    <h5><span>Shared publicly</span> - <span ng-bind="stream.timestamp | amDateFormat:'ddd, MMM Do YYYY, h:mm a'"></span>, <span am-time-ago="stream.timestamp"></span> </h5>
                </div>
                <div class="panel-body">
                    <p bind-html-compile="stream.post" class="wordBreak"></p>
                    <a class="panel-google-plus-image" href="#" ng-if="stream.attached_file">
                        <img ng-src="{[{ stream.attached_file }]}" ng-if="stream.type === 'image'"/>
                        <video ng-src="{[{ stream.attached_file }]}" controls ng-if="stream.type === 'video'"></video>
                    </a>
                    <div ng-if="isShared" class="repostContainer">
                       <p bind-html-compile="reShares.post" class="wordBreak"></p>
                       <div ng-if="reShares.attached_file">
                         <img ng-src="{[{ reShares.attached_file }]}" ng-if="reShares.type === 'image'" style="width: 100%" />
                         <video ng-src="{[{ reShares.attached_file }]}" controls ng-if="reShares.type === 'video'" style="width: 100%"></video>
                       </div>
                    </div>
                </div>
                <div class="panel-footer clearfix no-p-top">
                    <span class="hand" ng-bind-html="likes['noOfLikes']" ng-click="showLikersAndSharers(stream.id,'likers')"></span>
                    <span class="hand" ng-bind-html="shares['noOfShares']" ng-click="showLikersAndSharers(stream.id,'sharers')"></span>
                    <div class="clearfix p-bottom-5"></div>
                    <button type="button" class="btn btn-default likeBtn" 
                    ng-click="$streams.$likePost(stream.id)">
                      <i class="fa fa-fw" ng-class="{ 'fa-thumbs-up' : likes['isLiked'], 'fa-thumbs-o-up' : !likes['isLiked'] }" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-default" popover-trigger="'outsideClick'" uib-popover-template="'shareProviderOptions.html'" popover-placement="bottom">
                        <span class="fa fa-share fa-fw"></span>
                    </button>
                    <button type="button" class="btn btn-default" ng-click="$streams.$variable.showCommentList = !$streams.$variable.showCommentList">
                        <i class="fa fa-commenting fa-fw"></i>
                        {[{ comments.length? comments.length : ""}]}
                    </button>
                    <button type="button" class="btn btn-default" popover-trigger="'outsideClick'" uib-popover-template="'options.html'" popover-placement="bottom">
                        <span class="fa fa-cog fa-fw"></span>
                    </button>
                    <script type="text/ng-template" id="shareProviderOptions.html">
                      <div class="form-group shareDiv no-m-bottom">
                        <ul class="no-m-bottom">
                          <li>
                            <a href="#" ng-click="$streams.$share('facebook', stream.uid  + '!' +  stream.id)"><i class="fa fa-facebook fa-fw"></i> Facebook</a>
                          </li>
                          <li>
                            <a href="#" ng-click="$streams.$share('twitter', stream.uid  + '!' + stream.id)"><i class="fa fa-twitter fa-fw"></i> Twitter</a>
                          </li>
                          <li>
                            <a href="#" ng-click="$streams.$share('google', stream.uid  + '!' + stream.id)"><i class="fa fa-google fa-fw"></i> Google</a>
                          </li>
                        <ul>
                      </div>    
                    </script>
                    <script type="text/ng-template" id="options.html">
                      <div class="form-group optionDiv no-m-bottom">
                        <ul class="no-m-bottom" style="padding: 0px; list-style: none">
                          <li>
                            <a href="#" ng-click="showRepostModal(stream)"><i class="fa fa-retweet fa-fw"></i> Repost</a>
                          </li>
                        <ul>
                      </div>    
                    </script>
                </div>
                <div class="panel-google-plus-comment" ng-if="$streams.$variable.showCommentList">
                    <img class="img-circle" ng-src="{[{ authenticatedUser.photoUrl }]}" style="width : 50px; height: 50px; border: 2px solid #337ab7"/>
                    <div class="panel-google-plus-textarea m-bottom-15">
                          <div class="form-group no-m-bottom comment-box">
                            <div ng-model="$streams.$variable.comments.text" id="commentArea" class="form-control postTextArea" contentEditable="true" strip-br="true" at-who user-data="userData" symbol-data="symbolData" style="padding-right: 0px; padding-left: 10px"  auto-resize start-height="100" data-text="Share your idea about stocks"></div>
                             <div class="overlay" ng-if="$streams.$variable.comments.isPosting"></div>
                          </div>   

                          <label class="img-thumbnail attachFile" title="Attach File" ng-class="{'noFile bg-primary' : !$streams.$variable.comments.file.isLoaded, 'withFile': $streams.$variable.comments.file.isLoaded }">
                                <input type="file" accept="image/*" class="form-control" file-read="$streams.$variable.comments.file" style="display:none" ng-disabled="$streams.$variable.comments.isPosting">
                                <i class="fa fa-bar-chart fa-lg fa-fw" aria-hidden="true" ng-if="!$streams.$variable.comments.file.isLoaded"></i>
                                <img ng-src="{[{ $streams.$variable.comments.file.src }]}" ng-if="$streams.$variable.comments.
                                file.isLoaded && $streams.$variable.comments.file.fileType == 'image'" class="imgFilePreview">
                                <video ng-src="{[{ $streams.$variable.comments.
                                file.src }]}" ng-if="$streams.$variable.comments.
                                file.isLoaded && $streams.$variable.comments.file.fileType == 'video'" class="videoFilePreview">
                                    Your browser does not support HTML5 video.
                                </video>
                                <i class="fa fa-times-circle fa-fw removeFileIcon" ng-if="$streams.$variable.comments.
                                file.isLoaded" ng-click="$streams.$closeCommentImage($event)"></i>
                           </label>
                           <div class="commentBtnPosition" ng-class="{'noFile' : !$streams.$variable.comments.file.isLoaded, 'withFile': $streams.$variable.comments.file.isLoaded }">
                              <button type="submit" class="btn btn-success m-left-10" ng-disabled="!$streams.$variable.comments.text.length" ng-click="$streams.$postComment(stream.id)">
                                  <span ng-if="$streams.$variable.comments.isPosting">
                                      <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i> Posting
                                  </span>
                                  <span ng-if="!$streams.$variable.comments.isPosting">
                                      Post comment
                                  </span>
                              </button>
                              <button type="reset" class="btn btn-default" ng-click="$streams.$cancelComment()" >Cancel</button>
                           </div>
                       
                    </div>
                    <div class="clearfix"></div>
                    <div ng-repeat="comment in comments | orderBy : timestamp : true">
                        <hr class="no-m-top" style="border-top: 1px solid #d5d5d5" />
                        <div class="form-group">
                            <div class="clearfix w-100">
                                <div class="w-100 clearfix">
                                     <div class="pull-left">
                                        <img class="img-circle img-responsive" ng-src="{[{ comment.user_info.photo }]}" alt="profile_photo" style="width : 50px; height: 50px;border: 2px solid #337ab7" popover-trigger="'outsideClick'" uib-popover-template="'comment_profile.html'" popover-placement="right-top"/>
                                        <script type="text/ng-template" id="comment_profile.html">
                                            <div class="form-group text-center">
                                                <img class="img-circle img-responsive pop-up-profile" ng-src="{[{ comment.user_info.photo }]}" alt='profilePhoto'>
                                            </div>
                                            <div class="form-group text-center">
                                                     <p class="lead no-m-bottom hand" ng-click="mentionClick(comment.uid)" data-ng-bind="comment.user_info.fullname"></p>
                                                     <p class="text-primary" data-ng-bind="comment.user_info.email"></p>
                                                     <button class="btn btn-primary btn-rounded btn-block m-top-10 f-18" ng-click="followUser(comment.uid)" ng-if="!checkIfAlreadyFollowed(comment.uid, authenticatedUser.uid) && authenticatedUser.uid != comment.uid">Follow</button>
                                                     <button class="btn btn-primary btn-rounded btn-block m-top-10 f-18" ng-click="unFollowUser(comment.uid)" ng-if="checkIfAlreadyFollowed(comment.uid, authenticatedUser.uid) && authenticatedUser.uid != comment.uid">Unfollow</button>
                                            </div>
                                        </script>
                                     </div>
                                     <div class="pull-left m-5">
                                        <p ng-bind="comment.user_info.fullname" class="no-m-bottom bolder hand" ng-click="mentionClick(comment.uid)"></p>
                                        <p class="text-muted f-12"> 
                                            <span ng-bind="comment.timestamp | amDateFormat:'ddd, MMM Do YYYY, h:mm a'"></span>, <span am-time-ago="comment.timestamp"></span>
                                        </p>
                                     </div>
                                </div>
                                <p bind-html-compile="comment.post" class="wordBreak"></p>
                                <div class="w-100" ng-if="comment.attached_file">
                                    <img ng-src="{[{ comment.attached_file }]}" ng-if="comment.type === 'image'" style="max-width: 100% ; vertical-align: bottom;" />
                                    <video ng-src="{[{ comment.attached_file }]}" controls ng-if="comment.type === 'video'" style="max-width: 100% ; width : 100%;vertical-align: bottom;"></video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="form-group pull-right f-18">
              <a href="/stream" class="no-text-decoration"><i class="fa fa-mail-reply"></i> Go to Streams</a>
            </div>
        </div>
    </div>
<!-- end -->


  </div>

  <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-default solid-corner watchlist">
          <div class="panel-body">
              <div class="icon">
                <i class="fa fa-list-alt f-25"></i>
              </div>
              <ul class="list-group">       
                <li class="list-group-item" ng-repeat="symbolDetails in watchList track by $index">
                   <div class="w-100 p-left-20 p-right-10 clearfix">
                     <span class="w-100 clearfix">
                      <a href="#" class="list-group-item-heading pull-left bolder" ng-click="symbolClick(symbolDetails.symbol)" ng-bind="symbolDetails.symbol"></a>
                        <span class="pull-right f-18" ng-bind="symbolDetails.open">0.051</span>
                     </span>
                     <span class="w-100 clearfix">
                        <span class="list-group-item-text f-10 text-muted" ng-bind="symbolDetails.name">A-CAP RESOURCES LIMITED</span>
                        <span class="pull-right f-15" ng-class="{'rate-up-text' : symbolDetails.change >= 0,'rate-down-text' :  symbolDetails.change < 0 }" >
                        <span class="fa fa-fw" ng-class="{'fa-arrow-circle-o-up' : symbolDetails.change >= 0,'fa-arrow-circle-o-down' : symbolDetails.change < 0 }">
                        </span>
                        <span ng-bind="symbolDetails.change">0.004</span>
                        (<span ng-bind="symbolDetails.percentage">0.004</span>)
                        </span>
                     </span>
                   </div>
                   <span class="box left primary">  
                   </span>
                   <span class="box right" ng-class="{'green' : symbolDetails.change >= 0,'red' :  symbolDetails.change < 0, 'primary' : symbolDetails.change === 'NA'}"> 
                   </span>
                </li> 
              </ul>
              <div class="label">
                   WATCHLIST
              </div>
          </div>
         </div>
         <div class="panel panel-default solid-corner watchlist" style="margin-top: 45px;">
          <div class="panel-body">
              <div class="icon">
                <i class="fa fa-line-chart f-25"></i>
              </div>
              <ul class="list-group">       
                <li class="list-group-item" ng-repeat="symbolDetails in trending track by $index">
                   <div class="w-100 p-left-20 p-right-10 clearfix">
                     <span class="w-100 clearfix">
                      <a href="#" class="list-group-item-heading pull-left bolder" ng-click="symbolClick(symbolDetails.symbol)" ng-bind="symbolDetails.symbol"></a>
                        <span class="pull-right f-18" ng-bind="symbolDetails.open">0.051</span>
                     </span>
                     <span class="w-100 clearfix">
                        <span class="list-group-item-text f-10 text-muted" ng-bind="symbolDetails.name">A-CAP RESOURCES LIMITED</span>
                        <span class="pull-right f-15" ng-class="{'rate-up-text' : symbolDetails.change >= 0,'rate-down-text' :  symbolDetails.change < 0 }" >
                        <span class="fa fa-fw" ng-class="{'fa-arrow-circle-o-up' : symbolDetails.change >= 0,'fa-arrow-circle-o-down' : symbolDetails.change < 0 }">
                        </span>
                        <span ng-bind="symbolDetails.change">0.004</span>
                        (<span ng-bind="symbolDetails.percentage">0.004</span>)
                        </span>
                     </span>
                   </div>
                   <span class="box left primary">  
                   </span>
                   <span class="box right" ng-class="{'green' : symbolDetails.change >= 0,'red' :  symbolDetails.change < 0, 'primary' : symbolDetails.change === 'NA'}"> 
                   </span>
                </li> 
              </ul>
              <div class="label">
                   TRENDING
              </div>
          </div>
         </div>
  </div>


</div>	 
</div>
<script type="text/ng-template" id="likersAndSharersModal.html">
        <div class="modal-header">
           <ul class="nav nav-pills pull-left">
              <li ng-class="{'active' : options === 'likers'}" ng-click="options = 'likers'; setOptions(options)"><a href="#">Likes</a></li>
              <li ng-class="{'active' : options === 'sharers'}" ng-click="options = 'sharers'; setOptions(options)"><a href="#">Shares</a></li>
           </ul>         
           <i class="fa fa-times hand pull-right" style="margin-top: 13px;
    margin-right: 5px;" ng-click="close()"></i>
        </div>
        <div class="modal-body" id="modal-body" style="max-height: 250px">
           <ul ng-scrollbars ng-scrollbars-config="config" style="max-height: 210px; padding: 0; list-style-type: none;">
              <li class="w-100 p-left-5" ng-repeat="user in userList">
                <div class="row w-100">
                     <div class="col-md-2">
                        <img class="imgCircle" ng-src="{[{ user.photoUrl }]}" alt="profile">
                     </div>
                     <div class="col-md-10">
                        <h2 ng-bind="user.firstname + ' ' + user.lastname" class="m-top-10 m-bottom-5 text-primary hand"></h2>
                        <span ng-bind="user.email"></span>
                     </div>
                </div>
              </li>
              <li class="w-100 p-left-5" ng-if="!userList.length">
                <div class="row w-100">
                  <div class="col-md-12 text-center f-25">
                    <i class="fa fa-ban"></i> No Result Found
                  </div>    
                </div>
              </li>
           </ul>
        </div>
        <div class="modal-footer">
            <button class="btn btn-default" type="button" ng-click="close()">Close</button>
        </div>
</script>
<script type="text/ng-template" id="repostStreamsModal.html">

        <div class="modal-header">
           <h4 class="pull-left">Repost</h3>
           <i class="fa fa-times hand pull-right m-top-15 m-right-10" ng-click="close()"></i>
        </div>
        <div class="modal-body" id="modal-body">
          
          <div class="form-group no-m-bottom post-box" style="position: relative;">
              <div ng-model="stream.post" id="rePostTxArea" class="form-control postTextArea" contentEditable="true" at-who user-data="userData" symbol-data="symbolData" auto-resize start-height="100" data-text="Share your idea about stocks"></div>
              <div class="overlay" ng-if="isPosting"></div>
          </div>

          <label class="img-thumbnail attachFile" title="Attach File" ng-class="{'noFile bg-primary' : !file.isLoaded, 'withFile': file.isLoaded }">
          <input type="file" accept="image/*" class="form-control" file-read="file" style="display:none" ng-disabled="isPosting">
          <i class="fa fa-bar-chart fa-lg fa-fw" aria-hidden="true" ng-if="!file.isLoaded"></i>
          <img ng-src="{[{ file.src }]}" ng-if="file.isLoaded && file.fileType == 'image'" class="imgFilePreview">
          <video ng-src="{[{ file.src }]}" ng-if="file.isLoaded && file.fileType == 'video'" class="videoFilePreview">
              Your browser does not support HTML5 video.
          </video>
          <i class="fa fa-times-circle fa-fw removeFileIcon" ng-if="file.isLoaded" ng-click="closeImage($event)"></i>
          </label>

          <div class="repostContainer">
              <p ng-bind-html="repostData.post"></p>
              <div class="form-group" ng-if="repostData.attached_file">
                 <img ng-src="{[{ repostData.attached_file }]}" style="width: 100%" ng-if="repostData.type === 'image'">
                 <video ng-src="{[{ repostData.attached_file }]}" style="width: 100%" ng-if="repostData.type === 'video'">       Your browser does not support HTML5 video.
                 </video>
              </div>
          </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-info" ng-disabled="!stream.post.length" ng-click="savePost()">
              <i class="fa fa-1x fa-fw" ng-class="{'fa-save' : !isPosting, 'fa-circle-o-notch fa-spin' : isPosting}"></i>
               Post
            </button>
            <button class="btn btn-default" type="button" ng-click="close()">Close</button>
        </div>
</script>
@endsection        

@section('page-js')
<!-- Controller JS -->
<script type="text/javascript" src="/app/fe-app/controllers/stream_detail.js"></script>
  
@endsection

