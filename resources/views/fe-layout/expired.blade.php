@extends('fe-layout.main.app')

@section('title', 'Account Activation Expired')

@section('content')             
<div class="col-md-8 col-md-offset-2 col-xs-12 right-section m-top-10" id="expired">
   
    <div class="bg-inverse bg-red text-white">
        <h4> &nbsp; <i class="fa fa-exclamation-circle"></i> Error </h4>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
             <div class="panel panel-default solid-corner">
                <div class="panel-body">
                   <div class="m-left-5">
                        <h2 class="text-danger m-top-5">
                            <span class="fa-stack fa-lg">
                              <i class="fa fa-user fa-stack-1x text-muted"></i>
                              <i class="fa fa-ban fa-stack-2x text-danger"></i>
                            </span> 
                            Account Activation 
                            @if($state == "expired")
                                Expired 
                            @else
                                is Invalid
                            @endif
                        </h2>
                        <p class="f-18">
                        You account activation has been expired {{ $state }}.
                        </p>    
                    </div>
                </div>
            </div>
            </div>
        </div>
         
        </div>
</div>
@endsection        
