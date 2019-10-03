 <div class="form-group" id="chatBoxWrapper" data-ng-controller="chatCtrl" ng-show="firebaseUser">   
    <div class="chatBox" ng-show="isChatBoxShowed">
      
      <div class="chatBoxHeader"> 
          <div ng-if="isSelectedUser && !isForwarding" class="animate">
            <span class="w-100"> 
              <span class="pull-left text-white m-top-10 hand" ng-click="closeChat()">
                <i class="fa fa-angle-left fa-2x fa-fw"></i>
              </span>
              <span class="pull-left">
                 <img alt="User Pic" ng-src="{[{ $variable.photo.receiver }]}" class="img-circle img-responsive chat-profile">
              </span>
              <span class="pull-left m-top-15 m-left-10 text-white" data-ng-bind="selectedUserInfo.firstname + ' ' + selectedUserInfo.lastname">Shou Setsuna </span>
            </span>
          </div>
          <div ng-if="!isSelectedUser" class="animate">
            <div class="box">
              <div class="container-1">
                  <input type="search" id="search" placeholder="Search..." autocomplete="off" ng-model="$variable.searchTxt" />
                  <span class="icon">
                    <i class="fa fa-search" ng-if="!$variable.searchTxt.length"></i>
                    <i class="fa fa-times hand" ng-click="$clearSearch()" ng-if="$variable.searchTxt.length"></i>
                  </span>
              </div>
            </div>
          </div>
          <div ng-if="isForwarding" class="animate">
             <span class="pull-left text-white m-top-10 hand" ng-click="$closeForwardContainer()">
                <i class="fa fa-angle-left fa-2x fa-fw"></i>
              </span>
            <div class="box isForwarding">
              <div class="container-1">
                  <input type="search" id="search" placeholder="Search..." autocomplete="off" ng-model="$variable.searchTxt" />
                  <span class="icon">
                    <i class="fa fa-search" ng-if="!$variable.searchTxt.length"></i>
                    <i class="fa fa-times hand" ng-click="$clearSearch()" ng-if="$variable.searchTxt.length"></i>
                  </span>
              </div>
            </div>
          </div>
      </div>

      <div ng-if="!isSelectedUser" class="animationIf">
        
        <ul class="nav nav-tabs" >
          <li ng-class="{'active' : $variable.tab === 1}">
            <a data-toggle="tab" href="#latestMessages" ng-click="$variable.searchTxt = ''; $variable.tab = 1">Messages</a>
          </li>
          <li ng-class="{'active' : $variable.tab === 2}">
            <a data-toggle="tab" href="#following" ng-click="$variable.searchTxt = ''; $variable.tab = 2">Following</a>
          </li>
           <li ng-class="{'active' : $variable.tab === 3}">
            <a data-toggle="tab" href="#suggested" ng-click="$variable.searchTxt = ''; $variable.tab = 3">Suggested</a>
          </li>
        </ul>
    
        <div class="tab-content" >
          <div id="latestMessages" class="tab-pane fade in" ng-class="{'active' : $variable.tab === 1}">
            <div class="chatMessagesList" >
              <span ng-if="!ifAllIsLoaded" class="animationIf loadingMsg">
                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </span>
              <ul ng-scrollbars ng-scrollbars-config="config" ng-if="ifAllIsLoaded && $variable.tab === 1" class="animationIf ulMsg">
                <li ng-repeat="msg in $latestMsgList | filter : filters.messaging">
                  <a href="#" ng-click="chatUser(msg.uid)">
                    <div class="row" style="margin :0">
                       <div class="col-md-2">
                          <img alt="User Pic" ng-src="{[{msg.photo_url}]}" class="img-circle img-responsive chat-profile">
                       </div>
                       <div class="col-md-10" style="width: 83%">
                         <p class="text-muted m-top-5">
                            <span class="pull-left f-12" data-ng-bind="msg.full_name">
                            </span>
                            <span class="pull-right f-12 time-elapsed" am-time-ago="msg.timestamp">
                            </span>
                         </p>
                         <p class="msg-body" data-ng-bind="msg.message">
                         </p>
                       </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div id="following" class="tab-pane fade in" ng-class="{'active' : $variable.tab === 2}">
            <div class="chatMessagesList" >
              <span ng-if="!ifAllIsLoaded" class="animationIf loadingMsg">
                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </span>
              <ul ng-scrollbars ng-scrollbars-config="config"  ng-if="ifAllIsLoaded && $variable.tab === 2" class="animationIf ulMsg">
                <li ng-repeat="buddy in buddyList | filter : filters.following" style="overflow: visible;">
                 <a href="#">
                    <div class="row" style="margin :0">
                       <div class="col-md-2">
                          <img alt="User Pic" ng-src="{[{ buddy.photoUrl }]}" class="img-circle img-responsive chat-profile">
                       </div>
                       <div class="col-md-10" style="width: 82%">
                         <p class="text-muted w-100">
                            <span class="pull-left" data-ng-bind="buddy.firstname + ' ' + buddy.lastname">
                            </span>
                            <span class="pull-right icon clearfix" popover-trigger="'outsideClick'" popover-animation="true"  uib-popover-template="'menuTemplate.html'" popover-placement="left-top">
                                <i class="fa fa-ellipsis-v f-18 m-top-5"></i>
                            </span>
                            <script type="text/ng-template" id="menuTemplate.html">
                                <ul class="ulMenu">
                                  <li>
                                    <a href="#" ng-click="chatUser(buddy.uid)"><i class="fa fa-comments-o"></i> Chat</a>
                                  </li>
                                  <li>
                                    <a href="#" ng-click="unFollowUser(buddy.uid)"><i class="fa fa-user-times"></i> Unfollow</a>
                                  </li>
                                </ul>
                            </script>
                         </p>
                         <p class="text-left m-left-15 email-content" data-ng-bind="buddy.email">
                         </p>
                       </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div id="suggested" class="tab-pane fade in" ng-class="{'active' : $variable.tab === 3}">
            <div class="chatMessagesList" >
              <span ng-if="!ifAllIsLoaded" class="animationIf loadingMsg">
                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
              </span>
              <ul ng-scrollbars ng-scrollbars-config="config"  ng-if="ifAllIsLoaded && $variable.tab === 3" class="animationIf ulMsg">
                <li ng-repeat="user in users | filter : filters.following" ng-if="!checkIfAlreadyRequested(user.uid, authenticatedUser.uid) && !checkIfAlreadyFollowed(user.uid, authenticatedUser.uid) && authenticatedUser.uid != user.uid">
                 <a href="#">
                    <div class="row" style="margin :0">
                       <div class="col-md-2">
                          <img alt="User Pic" ng-src="{[{ user.photoUrl }]}" class="img-circle img-responsive chat-profile">
                       </div>
                       <div class="col-md-10" style="width: 82%">
                         <p class="text-muted w-100">
                            <span class="pull-left" data-ng-bind="user.firstname + ' ' + user.lastname">
                            </span>
                            <span class="pull-right icon" ng-click="followUser(user.uid)">
                             <i class="fa f-25" ng-class="{'fa-user-times' : checkIfAlreadyRequested(user.uid, authenticatedUser.uid), 'fa-user-plus' : !checkIfAlreadyRequested(user.uid, authenticatedUser.uid)}"></i>
                            </span>
                         </p>
                         <p class="text-left m-left-15 email-content" data-ng-bind="user.email">
                         </p>
                       </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
       <!--  <button class="newConvoButton btn btn-default btn-rounded" ng-click="isSelectedUser = !isSelectedUser">
              <i class="fa fa-edit"></i>
              New Conversation
        </button> -->

      </div>
      <div ng-if="isSelectedUser && !isForwarding" class="animationIf">
        <div class="chatMessagesList addedHeight
        " >
             <span ng-if="!ifLoaded" class="animationIf loadingMsg">
                <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
             </span>
             <ul class="scale ulMsg withChat" ng-if="ifLoaded" ng-scrollbars ng-scrollbars-config="config" ng-scrollbars-update="callbacks.updateScrollbar">
                <li ng-repeat="msg in messageList" id="{[{ 'li' + msg.$id }]}" long-press="$selectedMsg(msg)">
                  <a href="#" class="clearfix" >
                   <div class="row row-eq-height" style="margin-right: -2px" ng-show="authenticatedUser.uid != msg.sentby">
                      <div class="col-md-2">
                        <img alt="User Pic" ng-src="{[{ $variable.photo.receiver }]}" class="img-circle img-responsive chat-profile h-w-30 m-left-10 m-right-20">
                      </div>
                      <div class="col-md-10 msgItem leftBubble">
                        <span class="pull-right clearfix text-muted f-12" am-time-ago="msg.timestamp"></span>
                        <p class="breakWord m-top-10 pull-left" data-ng-bind="msg.message">
                        </p>
                        <small class="pull-right" style="margin-top: 2px" data-ng-bind="$variable.isSending.text[$index]"></small>
                        <span class="pull-right m-right-5" ng-if="$variable.isSending.status[$index]">
                             <i class="fa fa-circle-o-notch fa-pulse fa-1x fa-fw"></i>
                        </span>
                      </div>
                    </div>
                    <div class="row row-eq-height" style="margin-right: 5px; margin-left: -3px" ng-show="authenticatedUser.uid == msg.sentby">
                      <div class="col-md-10 msgItem rightBubble">
                        <span class="pull-right clearfix text-muted f-12" am-time-ago="msg.timestamp"></span>
                        <p class="breakWord m-top-10 pull-right text-right" data-ng-bind="msg.message">
                        </p>
                        <small class="pull-right" style="margin-top: 2px" data-ng-bind="$variable.isSending.text[$index]"></small>
                        <span class="pull-right m-right-5" ng-if="$variable.isSending.status[$index]">
                             <i class="fa fa-circle-o-notch fa-pulse fa-1x fa-fw"></i>
                        </span>
                      </div>
                      <div class="col-md-2">
                        <img alt="User Pic" ng-src="{[{ $variable.photo.sender }]}" class="img-circle img-responsive chat-profile h-w-30 m-left-10 m-right-5">
                      </div>
                    </div>
                  </a> 
                </li>
             </ul>
             <div ng-if="$variable.selectedMsg" class="divOverLay" ng-click="$unselectMsg()">
                               
             </div>
        </div>
        <div ng-if="!$variable.selectedMsg" class="scale">
          <div class="form-group" >
             <div class="input-group">
               <input type="text" placeholder="Type your message here..." class="form-control solid-corner" ng-model="$variable.message" ng-enter="sendMessages($variable.message)" aria-label="">
               <span class="input-group-addon solid-corner addOn">
                   <i class="fa fa-smile-o fa-fw"></i>
                   <i class="fa fa-paperclip fa-fw fa-flip-horizontal"></i>
              </span>
            </div>
          </div>
        </div>
        <div ng-if="$variable.selectedMsg" class="scale clearfix clipBoardWrapper">
          <div class="form-group no-m-bottom">
             <div class="clipBoardContainer">
                 <i class="fa fa-trash fa-2x fa-fw m-right-10 hand" ng-click="$removeMsg($variable.selectedMsg)"></i>
                 <i class="fa fa-mail-forward fa-2x fa-fw hand" ng-click="$showForwardContainer()"></i>
                 <i class="fa fa-copy fa-2x fa-fw m-left-10 hand" 
                 ngclipboard 
                 ngclipboard-success="$copyMsg(e);"
                 ngclipboard-error="$copyMsgError(e);" 
                 data-clipboard-text="{[{ $variable.selectedMsg.message }]}"></i>
             </div>
             <div class="closeContainer hand" ng-click="$unselectMsg()">
                     <i class="fa fa-times fa-18 fa-fw"></i>
             </div>
          </div>
        </div>
      </div>
      <div ng-if="isForwarding" class="animationIf">
          <div class="forwardContainer">
            <p class="m-bottom-5 text-center p-5 bg-dark-blue">Forward to </p>
            <div class="p-left-10 p-right-10">
                <pre class="no-m-bottom" data-ng-bind="$variable.selectedMsg.message"></pre>
                <div class="chatMessagesList">
                   <ul class="ulMsg withForwarding" ng-scrollbars ng-scrollbars-config="config">
                    <li ng-repeat="buddy in buddyList | filter : filters.following" ng-if="buddy.uid !== selectedUserUID">
                     <a href="#">
                        <div class="row" style="margin :0">
                           <div class="col-md-2">
                              <img alt="User Pic" ng-src="{[{ buddy.photo_url }]}" class="img-circle img-responsive chat-profile">
                           </div>
                           <div class="col-md-10" style="width: 82%">
                             <p class="text-muted w-100">
                                <span class="pull-left" data-ng-bind="buddy.firstname + ' ' + buddy.lastname">
                                </span>
                                <span class="pull-right icon" ng-click="$forwardMsg(buddy.uid, $index)">
                                    <button class="btn btn-primary btn-rounded btn-sm" ng-if="$variable.isForwarding.status[$index] === undefined">
                                      Send
                                    </button>
                                    <span  ng-if="$variable.isForwarding.status[$index] === true"> 
                                        <i class="fa fa-circle-o-notch fa-spin f-25 fa-fw text-primary"></i>
                                    </span>
                                    <span class="text-primary" ng-if="$variable.isForwarding.status[$index] === false">Sent</span>
                                </span>
                             </p>
                             <p class="text-left m-left-15 email-content withForwarding" data-ng-bind="buddy.email">
                             </p>
                           </div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
            </div>
          </div>
      </div>
    </div>
    <div class="chatButtonWrapper">
     <button class="btn btn-primary chatButton ripple"  ng-click="showChatBox(isChatBoxShowed)" ng-class="{ 'addedPadding' : isChatBoxShowed}" >
        <div ng-if="!isChatBoxShowed"> 
          <i class="fa fa-comments fa-2x"></i>
        </div>
        <div ng-if="isChatBoxShowed">
          <i class="fa fa-times fa-2x" ></i>
        </div>
     </button>
   </div>
</div>


<script type="text/ng-template" id="forwardMessageModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">The  modal!</h3>
        </div>
        <div class="modal-body" id="modal-body">
            Having multiple modals open at once is probably bad UX but it's technically possible.
        </div>
</script>

<!-- Controller JS -->
<script type="text/javascript" src="/app/fe-app/controllers/chat.js"></script>
