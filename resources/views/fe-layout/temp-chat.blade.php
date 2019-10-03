@extends('fe-layout.main.app')

@section('title', 'Temp. Chat Layout')

@section('content')             
<div class="col-md-6 col-xs-12 right-section" id="tempChat" >
   
    <div class="bg-inverse text-white">
        <h4> &nbsp; <i class="fa fa-check-circle"></i> Temp. Chat Layout </h4>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-12 no-p-top">
             <div class="panel panel-default solid-corner">
                <div class="panel-body">
                   <div class="m-left-5">
                        <div class="list-group clearfix" ng-if="$variable.recipient_uid">
                            
                            <a href="#" class="list-group-item m-bottom-5" ng-class="{'pull-right' : authenticatedUser.$id == message.sentby, 'pull-left' : authenticatedUser.$id != message.sentby}"  ng-repeat="message in messages" style="clear:both; width : 45% !important">
                              <strong  class="pull-right" am-time-ago="message.timestamp"></strong>
                               <p class="list-group-item-text" style="clear:both;" data-ng-bind="message.message"></p>
                               <small class="pull-right" style="margin-top: 3.2px" data-ng-bind="$variable.isSending.text[$index]">Sending</small>
                                <span class="pull-right m-left-5" ng-if="$variable.isSending.status[$index] === true">
                                 <i class="fa fa-circle-o-notch fa-pulse fa-1x fa-fw"></i>
                               </span>
                            </a>
                        </div>
                        <div class="form-group">
                           <div class="input-group">
                             <input type="text" class="form-control" ng-model="$variable.message" ng-enter="sendMessages($variable.message)" aria-label="">
                             <span class="input-group-btn">
                              <button class="btn btn-default" type="button" ng-click="sendMessages($variable.message)">Chat</button>
                            </span>
                          </div>
                        </div>
                        <div class="form-group">
                              <style type="text/css">
                                 .graphLogo:hover{
                                      background: #f2f1f1;
                                 }
                              </style>
                              <label class="img-thumbnail graphLogo" style="position: relative;">
                                <input type="file" class="form-control" file-read="file" style="display:none">
                                <i class="fa fa-line-chart fa-2x fa-fw" aria-hidden="true" ng-if="!file.isLoaded"></i>
                                <img ng-src="{[{ file.src }]}"  style="height: 55px !important; width: 65px !important;" ng-if="file.isLoaded" >
                                <i class="fa fa-times-circle fa-fw" style="position: absolute; top: -6px; right: -11px; font-size: 18px;" ng-if="file.isLoaded" ng-click="closeImage($event)"></i>
                              </label>
                              <button class="btn btn-default" type="button" ng-click="uploadFile(file)">Upload</button>
                         
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
         
        </div>
</div>
<div class="col-md-3 col-xs-12 right-section" id="tempBuddyList">
   
    <div class="bg-inverse text-white">
        <h4> &nbsp; <i class="fa fa-check-circle"></i> Temp. Buddy List </h4>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-12 no-p-top">
             <div class="panel panel-default solid-corner">
                <div class="panel-body">
                   <div class="m-left-5">
                        <div class="list-group clearfix">
                            <a href="#" class="list-group-item m-bottom-5 clearfix"  ng-repeat="buddy in buddyList">
                                <h4 class="list-group-item-heading" data-ng-bind="buddy.firstname + ' ' + user.lastname"></h4>
                                <p class="list-group-item-text" data-ng-bind="buddy.email"></p>
                                <button class="btn btn-info btn-rounded pull-right m-top-10"  ng-class="{'btn-primary' : buddy.$id == $variable.recipient_uid, 'btn-info' : buddy.$id != $variable.recipient_uid}" ng-click="chat(buddy.$id)"><i class="fa fa-comments"></i> Chat</button> 
                             </a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
         
        </div>
</div>

<div class="col-md-3 col-xs-12 right-section" id="tempFollowList">
   
    <div class="bg-inverse text-white">
        <h4> &nbsp; <i class="fa fa-check-circle"></i> Temp. Follow List </h4>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-12 no-p-top">
             <div class="panel panel-default solid-corner">
                <div class="panel-body">
                   <div class="m-left-5">
                        <div class="list-group clearfix">
                            <a href="#" class="list-group-item m-bottom-5 clearfix"  ng-repeat="user in users" ng-if="!requests.$getRecord(user.$id) && checkIfAlreadyFollowed(user.$id, authenticatedUser.$id) && authenticatedUser.$id != user.$id">
                                <h4 class="list-group-item-heading" data-ng-bind="user.firstname + ' ' + user.lastname"></h4>
                                <p class="list-group-item-text" data-ng-bind="user.email"></p>
                                <button class="btn btn-info btn-rounded pull-right m-top-10" ng-click="follow(user.$id)"><i class="fa fa-plus"></i> Follow</button> 
                             </a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
         
        </div>
</div>

@endsection   



