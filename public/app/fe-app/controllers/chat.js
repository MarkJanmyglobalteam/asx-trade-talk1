'use strict';

asxTradeTalkApp.controller('chatCtrl', function($scope, $timeout, $ngConfirm, $rootScope, $document, $uibModal, moment, Auth, Ref, $firebaseObject, $firebaseArray,toastr,  FirebaseDatabase, FirebaseStorageRef){
  
     var followData = FirebaseDatabase.ref("followData");
     var buddychats = FirebaseDatabase.ref("buddychats");
     var users = FirebaseDatabase.ref("userData");
     var requests = FirebaseDatabase.ref("requests"); 
     var showedRequest = FirebaseDatabase.ref("showedRequest");
        
     $scope.users = $firebaseArray(users);
     $scope.followData = $firebaseArray(followData);
     $scope.requests = $firebaseArray(requests);
     $scope.messageList = $firebaseArray(buddychats);
     $scope.isSelectedUser = false;
     $scope.isForwarding = false;
     $scope.$variable = {
     	isSending : {
     		status : [],
     		text : [],
     	},
      isForwarding : {
        status : [],
      },
      searchTxt : '',
      tab : 1,
      selectedMsg : null,
      photo : {
         sender : "",
         receiver : ""
      },
      userPics : null 
     };

    $scope.ifAllIsLoaded = true;

    $scope.config = {
		    autoHideScrollbar: true,
	 	    theme: 'minimal-dark',
    		advanced:{
    			updateOnContentResize: true
    		},
    		scrollInertia: 0
    };

  	$scope.callbacks = {};

    $scope.filters = { 
         following : function(item){
          var $searchTxt = $scope.$variable.searchTxt;
          var $email = item.email.toLowerCase();
          var $firstname = item.firstname.toLowerCase();
          var $lastname = item.lastname.toLowerCase();
          if($searchTxt){
              $searchTxt = $searchTxt.toLowerCase();
              var fullDetails = $firstname + " " + $lastname + " " + $email;
              if(fullDetails.match($searchTxt)){

                  return true;
              }
              return false;
          }
          return true;
         },
         messaging : function(item){
          var $searchTxt = $scope.$variable.searchTxt;
          var $full_name = item.full_name.toLowerCase();
          if($searchTxt){
              $searchTxt = $searchTxt.toLowerCase();
              if($full_name.match($searchTxt)){

                  return true;
              }
              return false;
          }
          return true;
         }
    }

    Auth.$onAuthStateChanged(function(firebaseUser) {
     		if(firebaseUser){
     			$scope.loadRequestList(firebaseUser);
     			$scope.loadBuddyList(firebaseUser);
     			buddychats.child(firebaseUser.uid).on('value', function(){
					     	$scope.updateScrollbar();
     		   	   	if($scope.buddyList){
     		   	   	   $scope.loadLatestMsg(firebaseUser.uid);
     		   	   	}
     		   	});
     		}
     });

     $scope.loadBuddyList = function(firebaseUser){
           followData.child(firebaseUser.uid).on('value', function(data){
                 $scope.ifAllIsLoaded = false;
                 $scope.buddyList = [];
                 angular.forEach(data.val(), function(buddy, key){
                  $scope.users.$loaded().then(function(){
                     $scope.buddyList.push($scope.users.$getRecord(buddy.uid));
                  })
                 })
                 $scope.ifAllIsLoaded = true;
                 $timeout(function(){
                   $scope.loadLatestMsg(firebaseUser.uid); 
                 })
           });
     };

     $scope.loadLatestMsg = function(uid){
       	$scope.$latestMsgList = [];
        angular.forEach($scope.buddyList, function(value, key){
       		if(value){
            $scope.ifAllIsLoaded = false;
  	     		var $userInfo = $scope.users.$getRecord(value.uid);
  	     		buddychats.child(uid).child(value.uid).limitToLast(1).once('value',function(data){
  	     			var $dataVal = data.val();
  	     			if($dataVal !== null){
  		     			
                var $key = Object.keys($dataVal);
  		     			var $getVal = $dataVal[$key[0]];
                var $concat = $getVal.sentby === $rootScope.firebaseUser.uid? "You: " : "";

                $scope.$latestMsgList.push({ 
                      uid : value.uid,
                      full_name : $userInfo.firstname + " " + $userInfo.lastname,
                      timestamp : $getVal.timestamp,
                      message : $concat + $getVal.message,
                      photo_url : $userInfo.photoUrl
                });

              }
  	     		});
            $scope.ifAllIsLoaded = true;
  			}
  	   	})
     };
     
     $scope.chatUser = function(recipientUID){
         $scope.isSelectedUser = true;
         $scope.selectedUserUID = recipientUID;
         $scope.ifLoaded = false;
         $scope.selectedUserInfo = $scope.users.$getRecord(recipientUID);
         var $sender_uid = $rootScope.firebaseUser.uid; 
         var $recipient_uid = recipientUID;
         $scope.messageList = $firebaseArray(buddychats.child($sender_uid).child($recipient_uid));
         $scope.$variable.photo.sender = $rootScope.authenticatedUser.photoUrl;
         $scope.$variable.photo.receiver = $scope.selectedUserInfo.photoUrl;
         $timeout(function(){
           $scope.ifLoaded = true;
           $scope.updateScrollbar();
          }, 1000);
      
     };

     $scope.updateScrollbar = function(){
     	if($scope.ifLoaded){
	     	$timeout(function(){
	         	$scope.callbacks.updateScrollbar('scrollTo',"bottom");
            $scope.$apply();
	        });
     	}
     }

     $scope.closeChat = function(){
     	$scope.isSelectedUser = false;
      $scope.$variable.selectedMsg = null;
     };

     $scope.sendMessages = function(message){
        
        if(!message){
            return false;
        }

        var $message = message.trim();
        var $sender_uid =  $rootScope.firebaseUser.uid; 
        var $recipient_uid = $scope.selectedUserUID
        var $message_len = $scope.messageList.length;
        $scope.$variable.isSending.status[$message_len] = true;
        $scope.$variable.isSending.text[$message_len] = "Sending";
        buddychats.child($sender_uid).child($recipient_uid).push().set({
              message : $message,
              timestamp: firebase.database.ServerValue.TIMESTAMP,
              sentby : $sender_uid
        }).then(function(){
            buddychats.child($recipient_uid).child($sender_uid).push().set({
              message : $message,
              timestamp: firebase.database.ServerValue.TIMESTAMP,
              sentby : $sender_uid
            }).then(function(){
                 $scope.$variable.isSending.status[$message_len] = false;
                 $scope.$variable.isSending.text[$message_len] = "Sent";
                 $scope.$variable.message = null;
                 
            });
        });
     };

    $scope.isChatBoxShowed = false

    $scope.showChatBox = function(isChatBoxShowed){
           $scope.isChatBoxShowed = !isChatBoxShowed;
           if(!isChatBoxShowed){
           	   $scope.updateScrollbar();
               $scope.removeClass($scope.$variable.selectedMsg);
               $scope.isForwarding = false,
               $scope.$variable.searchTxt = "";
               $scope.$variable.isForwarding = {
                    status : [],
               };
           }
    };

    $scope.followUser = function(uid){
       
       // // console.log(uid, 'uid')
         followData.child($rootScope.firebaseUser.uid).push().set({
            uid : uid,
            type : "following"
         }).then(function(){
             followData.child(uid).push().set({
                 uid : $rootScope.firebaseUser.uid, 
                 type : "follower"
             }).then(function(){
                 $ngConfirm({
                   title : 'User Followed!',
                   content : 'User has been sucessfully followed.',
                   type : 'green',
                   typeAnimated : true,
                   buttons : {
                      ok : {
                         text : 'Ok',
                         btnClass : 'btn-primary',
                         action : function(){
                              
                         }
                      }
                   }
               });
            });
         });
      
    };

    $scope.unFollowUser = function(uid){
        var $followMainChild = $firebaseArray(followData.child($rootScope.firebaseUser.uid));
        var $followSecondChild = $firebaseArray(followData.child(uid));
        var $cont = true;
        $followMainChild.$loaded().then(function(data){
          angular.forEach(data, function(item, key){
              if($cont){
                  if(item.uid === uid){
                      $cont = false;
                      $followMainChild.$remove(item).then(function(){
                          var $cont1 = true; 
                          $followSecondChild.$loaded().then(function(data){
                              angular.forEach(data, function(item, key){
                                  if($cont1){
                                     if(item.uid === $rootScope.firebaseUser.uid){
                                        $cont1 = false;
                                        $followSecondChild.$remove(item).then(function(){
                                            $ngConfirm({
                                               title : 'User Unfollowed!',
                                               content : 'User has been sucessfully unfollowed.',
                                               type : 'green',
                                               typeAnimated : true,
                                               columnClass: 'col-md-3 col-md-offset-9',
                                               alignMiddle: false,
                                               buttons : {
                                                  ok : {
                                                     text : 'Ok',
                                                     btnClass : 'btn-primary',
                                                     action : function(){
                                                          
                                                     }
                                                  }
                                               }
                                           });
                                        })
                                     }
                                  }
                              })
                          })      
                      });
                  }
              }
          })
        })
    };

    $scope.loadRequestList = function(firebaseUser){
      var $requestsChild = requests.child(firebaseUser.uid);
      $requestsChild.on('child_added', function(request){
         var $requestSender = request.val().sender;
         var $requestList = $firebaseObject($requestsChild);
         $requestList.$loaded().then(function(){
            angular.forEach($requestList, function(request, key){
              if(request.sender === $requestSender){
                var sender_id = request.sender;
                var $user_info = $firebaseObject(users.child(sender_id));
                var $req = $requestsChild.child(key);
                $user_info.$loaded().then(function(data){
                  var $showedRequest = $firebaseArray(showedRequest.child(key));
                  var $userInfo = data;
                  $showedRequest.$loaded().then(function(data){
                    if(!data.length){
                          showedRequest.child(key).set({
                              "sender_id" : sender_id
                          })
                          $ngConfirm({
                             title: 'You received a Follow Request.',
                             content: $userInfo.firstname + ' ' +
                                       $userInfo.lastname + 
                                       ' has sent you a follow request.',
                             type: 'blue',
                             typeAnimated: true,
                             columnClass: 'col-md-4 col-md-offset-8',
                             alignMiddle: false,
                             buttons: {
                                 acceptRequest: {
                                     text: 'Accept',
                                     btnClass: 'btn-success',
                                     action: function(){
                                         followData.child(firebaseUser.uid).push().set({
                                            uid : sender_id
                                         }).then(function(){
                                             followData.child(sender_id).push().set({
                                                 uid : firebaseUser.uid 
                                             }).then(function(){
                                                 $req.remove().then(function(){
                                                    $showedRequest.$remove(data[0]);
                                                 });
                                             });
                                         });
                                     }
                                 },
                                 close: {
                                   text: 'No, Thanks',
                                     btnClass: 'btn-danger',
                                     action: function(){
                                        $req.remove().then(function(){
                                          $showedRequest.$remove(data[0]);
                                        });
                                     }
                                 }
                             }
                          });
                      }
                  })
                })
              }
            })
         })         
      })
    }

    $scope.checkIfAlreadyFollowed = function(uid, userUid){
      var $data = false;
      followData.child(userUid).on('value', function(data){
          angular.forEach(data.val(), function(user, key){
               if(!$data){
                  if(user.uid == uid){
                      $data = true;
                  }
               }
           });
      })
      return $data;
    }

    $scope.checkIfAlreadyRequested = function(uid, userUid){
    	var $data = false;
      requests.child(uid).on('value', function(data){
    		  var $dataVal = data.val();
    		  if($dataVal){
            angular.forEach($dataVal, function(user, key){
            	if(!$data){
                if(user.sender === userUid){
              		  $data = true;
              	} 
              }
            })
    		  }
    	})
    	return $data;
    }

    $scope.$clearSearch = function(){
         $scope.$variable.searchTxt = '';
    }

    $scope.$selectedMsg = function(selectedMsg){
        $scope.$variable.selectedMsg = selectedMsg;
    }

    $scope.$unselectMsg = function(){
        $scope.removeClass($scope.$variable.selectedMsg);
    }

    $scope.removeClass = function(msg){
      if(msg){
        angular.element("#li" + msg.$id).css({'background' : 'transparent'});
        $scope.$variable.selectedMsg = null;  
       } 
    }

    $scope.$onCopy = function(msg){
        new Clipboard('.fa fa-copy', {
            text: function(trigger) {
                return msg.message;
            }
        });
    }

    $scope.$copyMsg = function(e){
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
        $ngConfirm({
             title : null,
             content : 'Message has been copied to clipboard',
             type : 'green',
             typeAnimated : true,
             columnClass: 'col-md-3 col-md-offset-9',
             alignMiddle: false,
             buttons : {
                ok : {
                   text : 'Ok',
                   btnClass : 'btn-primary',
                   action : function(){
                       e.clearSelection();
                       $scope.removeClass($scope.$variable.selectedMsg);
                       $scope.$apply();
                   }
                }
             }
        });
        
    }

    $scope.$copyMsgError = function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    }


    $scope.$showForwardContainer = function(){
        $scope.isForwarding = true,
        $scope.$variable.searchTxt = "";
    }

    $scope.$closeForwardContainer = function(){
        $scope.isForwarding = false,
        $scope.$variable.searchTxt = "";
        $scope.$variable.selectedMsg = null;
        $scope.$variable.isForwarding = {
            status : [],
        };
        $scope.updateScrollbar();
    }

    $scope.$forwardMsg = function(recipient_uid, $index){
        var $message = $scope.$variable.selectedMsg.message.trim();
        var $sender_uid =  $rootScope.firebaseUser.uid; 
        var $recipient_uid = recipient_uid;
        $scope.$variable.isForwarding.status[$index] = true;
        buddychats.child($sender_uid).child($recipient_uid).push().set({
              message : $message,
              timestamp: firebase.database.ServerValue.TIMESTAMP,
              sentby : $sender_uid
        }).then(function(){
            buddychats.child($recipient_uid).child($sender_uid).push().set({
              message : $message,
              timestamp: firebase.database.ServerValue.TIMESTAMP,
              sentby : $sender_uid
            }).then(function(){
                 $scope.$variable.isForwarding.status[$index] = false;
            });
        });
    }

    $scope.$removeMsg = function(msg){
        
        $ngConfirm({
        title: 'Delete Message',
        content: 'Delete this message? This message will only be deleted in your end.',
        type: 'orange',
        typeAnimated: true,
        columnClass: 'col-md-3 col-md-offset-9',
        alignMiddle: false,
        buttons: {
            yes: {
                text: 'Yes',
                btnClass: 'btn-success',
                action: function(){
                     $scope.messageList.$remove(msg).then(function(response){
                           $ngConfirm({
                               title : 'Success',
                               content : 'Message has been deleted.',
                               type : 'green',
                               typeAnimated : true,
                               columnClass: 'col-md-3 col-md-offset-9',
                               alignMiddle: false,
                               buttons : {
                                  ok : {
                                     text : 'Ok',
                                     btnClass : 'btn-primary',
                                     action : function(){
                                         $scope.removeClass($scope.$variable.selectedMsg);
                                         $scope.$apply();
                                     }
                                  }
                               }
                           });
                     });
                }
            },
            cancel: {
              text: 'Cancel',
                btnClass: 'btn-danger',
                action: function(){
                    angular.element("#li" + $scope.$variable.selectedMsg.$id).css({'background' : 'transparent'});
                }
            }
        }
   });
      
   };

    // $scope.cancelRequest = function(uid, userUid){
    // 	var $request = $firebaseArray(requests.child(uid));
    // 	$request.$loaded().then(function(data){
    // 		angular.forEach(data, function(user, key){
    //         	if(user.sender === userUid){
    //         	     $request.$remove(key);
    //         	} 
    //         })
    // 	});
    // }
});