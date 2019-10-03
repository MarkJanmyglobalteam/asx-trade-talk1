@extends('fe-layout.main.app')

@section('title', 'Follow')

@section('content')             
<div class="col-md-6 col-xs-12 right-section" id="tempChat">
   
    <div class="bg-inverse text-white">
        <h4> &nbsp; <i class="fa fa-user-plus"></i> Follow User</h4>
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
                                <button class="btn btn-info btn-rounded pull-right m-top-10"  ng-class="{'btn-primary' : buddy.$id == $variable.recipient_uid, 'btn-info' : buddy.$id != $variable.recipient_uid}" ng-click="chat(buddy.$id)"><i class="fa fa-user-plus"></i> Follow</button> 
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