<nav class="navbar navbar-default no-m-bottom">
  <div class="container-fluid">
    <div class="navbar-header">
      <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#secondaryNav">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button> -->

      <a class="navbar-brand r-border" href="#"  data-toggle="collapse" data-target="#trending-list" ng-click="open(isOpen)">
          TRENDING <i class="fa" ng-class="{'fa-caret-right' : isOpen, 'fa-caret-down' : !isOpen}"></i> 
      </a>
    </div>
    <div class="collapse navbar-collapse" id="secondaryNav">
    	 <ul class="nav navbar-nav">
        <li class="bolder" ng-repeat="trend in mainTrending | limitTo : 3 track by $index" ng-click="gotoSymbol(trend)">
	      	<a href="#" style="color : #31708f">{[{ trend.symbol }]}
	          <span class="m-left-2" ng-class="{'rate-up-text' : trend.change >= 0,'rate-down-text' : trend.change < 0 }">
	      		<i class="fa fa-fw" ng-class="{'fa-arrow-circle-o-up' : trend.change >= 0,'fa-arrow-circle-o-down' :  trend.change < 0 }"></i> 
            {[{ trend.change + "(" + trend.percentage + ")" }]}
	      	  </span>
	      	</a>
	      </li>
	     </ul>
	    <ul class="nav navbar-nav navbar-right">
	      <li class="r-border bolder">
	      	<a>
	      		 <i class="fa fa-at text-primary bolder"></i> sample@email.com &nbsp;
	      		 <i class="fa fa-phone text-primary bolder"></i> +112-212-9009
	      	</a>
	      </li>
	      <li class="bolder">
	      	<a>
	      		<i class="fa fa-facebook text-primary m-right-5"></i>
	      		<i class="fa fa-google-plus text-primary m-right-5"></i>
	      		<i class="fa fa-pinterest-p text-primary m-right-5"></i>
	      		<i class="fa fa-twitter text-primary m-right-5"></i>
	      		<i class="fa fa-instagram text-primary"></i>
	      	</a>
	      </li>
		</ul>
   </div>
  </div>
</nav>
<div id="trending-list" class="collapse">
	<ul class="m-top-10 p-left-20">
		<li ng-repeat="trend in mainTrending track by $index" ng-click="gotoSymbol(trend)">
      <a href="#" ng-bind="trend.symbol"></a>
    </li>
	</ul>
</div>
<nav class="navbar navbar-inverse no-m-bottom no-padding">
  <div class="container-fluid">
    <div class="navbar-header nav_primary" >
      <button type="button" class="navbar-toggle mobile" data-toggle="collapse" data-target="#primaryNav">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="/">
      	<img src="/img/logo/asx_logo.png" alt="Dispute Bills" class="navbar-logo">
      </a>
    </div>
    <div class="collapse navbar-collapse" id="primaryNav">
	    <ul class="nav navbar-nav" id="mainLinks">
	      <li><a href="/stream">STREAMS</a></li>
	      <!-- 
        <li><a href="/article">ARTICLES</a></li>
	      <li><a href="/announcements/asx">ANNOUNCEMENTS</a></li>
         -->
        <li><a href="/stock">STOCKS</a></li>
  		  <li><a href="/movers">TOP MOVERS</a></li>
        <li class="dropdown" ng-init="isFocus = false; searchString = '';" ng-show="!isDoneSearching">
          <a class="dropdown-toggle search-toggle" ng-click="isFocus = false;" data-toggle="dropdown" href="#">
            <i class="fa fa-search"></i>
          </a>
          <ul class="dropdown-menu searchContainer" ng-class="{'search-menu' : !isFocus, 'search-menu-extend' : isFocus}">
            <li>
              <a href="#">
                <input type="text" class="search-input" ng-class="{'active' : isFocus}" ng-focus="isFocus = true;" name="search" placeholder="$ for Symbols, @ for Users" ng-model="searchString" ng-keyup="searchFnc(searchString);" ng-enter="gotoSearchPage(searchString);"/>
              </a>
            </li>
            <div ng-if="searchString.length && isFocus" class="autoComContainer" ng-class="{'noSymbol' : empty.isSymbolEmpty && searchKey === '$', 'noUser' : empty.isUserEmpty && searchKey === '@', 'bothNothing' : empty.isSymbolEmpty && empty.isUserEmpty && (searchKey !== '$' && searchKey !== '@'), 'oneHasContent' : ((empty.isSymbolEmpty && !empty.isUserEmpty) || (!empty.isSymbolEmpty && empty.isUserEmpty)) && (searchKey !== '$' && searchKey !== '@'), 'allHasContent' : !empty.isUserEmpty && !empty.isSymbolEmpty && (searchKey !== '$' && searchKey !== '@')}"
              >
              <div ng-if="searchKey === '$' || searchKey !== '@'" class="no-m-bottom">
                <div class="title">Symbols</div>
                <dl class="no-m-bottom" ng-class="{'noResult' : empty.isSymbolEmpty}" ng-scrollbars ng-scrollbars-config="config">
                  <dd class="hand" ng-repeat="symbol in symbolList | filter : filters.symbols | limitTo : 10" ng-click="gotoSymbol(symbol);">
                    <h4 class="no-m-top" ng-bind="symbol.symbol"></h4> -
                    <span ng-bind="symbol.name"></span>
                  </dd>
                  <dd class="f-18 p-right-10 text-center noRes" ng-if="empty.isSymbolEmpty = (symbolList | filter : filters.symbols).length == 0"><i class="fa fa-ban"></i> No results</dd>
                </dl>
              </div>
              <div ng-if="searchKey === '@' || searchKey !== '$'">
                <div class="title">Users</div>
                <dl class="no-m-bottom" ng-class="{'noResult' : empty.isUserEmpty}" ng-scrollbars ng-scrollbars-config="config" >
                  <dd ng-repeat="user in userList | filter : filters.users | limitTo : 10" class="w-100 clearfix hand" ng-click="gotoUser(user)">
                    <div class="pull-left">
                      <img ng-src="{[{user.photoUrl}]}" />
                    </div>
                    <h4 class="pull-left" ng-bind="user.firstname + ' ' + user.lastname"></h4>
                  </dd>
                  <dd class="f-18 p-right-10 text-center noRes" ng-if="empty.isUserEmpty = (userList | filter : filters.users).length == 0"><i class="fa fa-ban"></i> No results</dd>
                </dl>
              </div>
              <div class="seeAllResults hand" ng-click="gotoSearchPage(searchString);">
                <i class="fa fa-list"></i> See All Results
              </div>
            </div>
          </ul>
        </li>
		 </ul>
	    <ul class="nav navbar-nav navbar-right">
	      <li ng-if="!firebaseUser"><a href="/login">SIGN IN/ SIGN UP</a></li>
	      <li class="dropdown" ng-if="firebaseUser">
	        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <img class="profile-img" ng-src="{[{ authenticatedUser.photoUrl }]}" alt="profile"/>PROFILE
	        </a>
	        <ul class="dropdown-menu">
            <li><a href="#" ng-click=$main.$profile();>View Profile</a></li>
            <li><a href="#" ng-click="$main.$logout()">Logout</a></li>
	        </ul>
	      </li>
	    </ul>
   </div>
  </div>
  
</nav>


<!-- Profile Modal -->
<script type="text/ng-template" id="profileModal.html">
    <div class="modal-header">
        <h4 class="pull-left modal-title" id="modal-title">Account Settings</h4>
        <i class="fa fa-times hand pull-right m-top-5 m-right-10" ng-click="close()"></i>
    </div>
    <div class="modal-body no-padding" id="modal-body">
        <div class="form-group clearfix">
              <div class="form-group text-center">
                  <h3 class="text-info" ng-bind="profile.lastname + ' ' + profile.firstname"></h3>
              </div>
              <div class="form-group">
                <div  align="center">
                  <label title="Click to Change">
                      <img alt="User Pic" ng-src="{[{ file.src }]}" id="profile-image1" class="img-circle img-responsive" > 
                      <input class="hidden" type="file" accept="image/*" file-read="file" ng-disabled="isUpdating"> 
                   </label>
                   <div class="form-group" ng-if="profile.photoUrl != file.src">
                     <button class="btn btn-default btn-rounded" ng-click="saveImage()">
                         <i class="fa" ng-class="{ 'fa-save' : !isUpdating, 'fa-spinner fa-pulse' : isUpdating }"></i> Update
                     </button>
                   </div>
                </div>
              </div>
              <div class="form-group p-20">
                  <div class="row">
                      <div class="col-md-6 no-p-top">
                        <label>
                          First Name 
                        </label>
                        <div class="input-group" ng-init="firstnameEdit = false; firstnameDisabled = true">
                          <input type="text" name="firstname" ng-model="profile.firstname" class="form-control" required ng-disabled="firstnameDisabled"/>
                          <span class="input-group-btn" ng-click="firstnameEdit = !firstnameEdit">
                             <button class="btn btn-default" type="button" ng-click="updateRecord('firstname')">
                                <i class="fa" ng-class="{'fa-edit' : !firstnameEdit, 'fa-save' : firstnameEdit}"></i>
                             </button>
                          </span>
                        </div>
                      </div>
                      <div class="col-md-6 no-p-top">
                        <label>
                          Last Name 
                        </label>
                        <div class="input-group" ng-init="lastnameEdit = false; lastnameDisabled = true">
                          <input type="text" name="lastname" ng-model="profile.lastname" class="form-control" required ng-disabled="lastnameDisabled"/>
                          <span class="input-group-btn" ng-click="lastnameEdit = !lastnameEdit">
                             <button class="btn btn-default" type="button" ng-click="updateRecord('lastname')">
                                <i class="fa" ng-class="{'fa-edit' : !lastnameEdit, 'fa-save' : lastnameEdit}"></i>
                             </button>
                          </span>
                        </div>
                      </div>
                  </div>
                  <div class="row" ng-show="profile.provider === 'password'">
                      <div class="col-md-12  no-p-top">
                        <label>
                          Email Address
                        </label>
                        <div class="input-group" ng-init="emailEdit = false; emailDisabled = true">
                          <input type="text" name="email" ng-model="profile.email" class="form-control" required ng-disabled="emailDisabled"/>
                          <span class="input-group-btn" ng-click="emailEdit = !emailEdit">
                             <button class="btn btn-default" type="button" ng-click="updateEmail('email')">
                                <i class="fa" ng-class="{'fa-edit' : !emailEdit && !isLoading, 'fa-save' : emailEdit && !isLoading, 'fa-spinner fa-pulse' : isLoading}"></i>
                             </button>
                          </span>
                        </div>
                      </div>
                  </div>
                  <div class="row" ng-show="profile.provider === 'password'">
                      <div class="col-md-12  no-p-top p-bottom-5" ng-init="editPassword = false; editVerifiedPword = false;">
                        <label>
                          Password <small ng-if="editVerifiedPword">(Enter Current Password)</small>
                          <button class="btn btn-default btn-rounded m-left-5" ng-click="editVerifiedPword = true;" ng-show="!editVerifiedPword && !editPassword">
                            <i class="fa fa-edit"></i> Change
                          </button>
                        </label>
                        <div class="row" ng-show="editVerifiedPword">
                              <div class="col-md-7 no-p-right" id="verifiedPword">
                                  <input type="password" name="verified" ng-model="pword.verified" class="form-control">
                              </div>
                              <div class="col-md-5">
                                <button class="btn btn-default btn-rounded text-primary" ng-click="verifyPassword()">
                                  <i class="fa" ng-class="{ 'fa-check' : !isVerifying, 'fa-spinner fa-pulse' : isVerifying }"></i>
                                   Verify
                                </button>
                                <button class="btn btn-default btn-rounded text-danger" ng-click="editVerifiedPword = false;">
                                  <i class="fa fa-times"></i>
                                   Cancel
                                </button>
                              </div>
                        </div>
                        <div class="row" ng-show="editPassword">
                            <div class="col-md-5 no-p-top no-p-right" id="password">
                                <input type="password" name="password" ng-model="password" class="form-control">
                                <span ng-if="password">
                                <label class="control-label w-100 text-right no-p-top f-12">
                                    <em class="text-light-blue" ng-if="value < 50 && value >= 0">(Weak)</em><em class="text-light-orange" ng-if="value < 83 && value >= 50">(Medium)</em><em class="text-light-green" ng-if="value >= 83">(Strong)</em>
                                </label>
                                <div ng-password-strength="password" strength="value" strength="passStrength" inner-class="progress-bar" inner-class-prefix="progress-bar-"></div>
                                </span>
                            </div>
                            <div class="col-md-5 no-p-top" id="retype">
                                <input type="password" name="retype" ng-model="retype" class="form-control">
                            </div>
                            <div class="col-md-1 no-p-top no-p-left">
                                <button class="btn btn-default btn-rounded" ng-click="updatePassword()">
                                  <i class="fa" ng-class="{ 'fa-save' : !isPassLoading, 'fa-spinner fa-pulse' : isPassLoading }"></i>
                                   Save
                                </button>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12  no-p-top">
                        <label>
                          Address
                        </label>
                        <div class="input-group" ng-init="addressEdit = false; addressDisabled = true">
                          <input type="text" name="address" ng-model="profile.address" class="form-control" required ng-disabled="addressDisabled"/>
                          <span class="input-group-btn" ng-click="addressEdit = !addressEdit">
                             <button class="btn btn-default" ng type="button" ng-click="updateRecord('address')">
                                <i class="fa" ng-class="{'fa-edit' : !addressEdit, 'fa-save' : addressEdit}"></i>
                             </button>
                          </span>
                        </div>
                      </div>
                  </div>
              </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-default" type="button" ng-click="close()">Close</button>
    </div>
</script>
