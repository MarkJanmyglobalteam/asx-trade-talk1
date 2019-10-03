'use strict';

asxTradeTalkApp.controller('streamDetailCtrl', function($scope, $uibModal, Config, Auth, moment, store, $window, $firebaseObject, $ngConfirm, Utils, Socialshare, $filter, $timeout,  mainFtry, $firebaseArray, FirebaseDatabase, FirebaseStorageRef, $rootScope, EODSvc, toastr){
  
   var streams = FirebaseDatabase.ref("streams");
   var users = FirebaseDatabase.ref("userData");
   var likes = FirebaseDatabase.ref("likes");
   var comments = FirebaseDatabase.ref("comments");

   var followData = FirebaseDatabase.ref("followData");
   var requests = FirebaseDatabase.ref("requests"); 

   var tags = FirebaseDatabase.ref("tags"); 
   var watchlist = FirebaseDatabase.ref("watchlists"); 
   
   var shares = FirebaseDatabase.ref("shares");
   var reshares = FirebaseDatabase.ref("reshares");  
     
   $scope.streams = $firebaseArray(streams);
   $scope.users = $firebaseArray(users);
   $scope.like = $firebaseArray(likes);
   $scope.comment = $firebaseArray(comments);
   $scope.likes = [];
   $scope.comments = [];
   $scope.userData = [];
   $scope.symbolData = [];
  
   Auth.$onAuthStateChanged(function(firebaseUser) {
      if(firebaseUser){

        var $currentUrl = $window.location.href;
        var $pathNameArr = $window.location.pathname.split( '/' );
        var $pathArr = $pathNameArr[2].split("!");
        var $streamUID = $pathArr[1];
        var $userUID = $pathArr[0];
        
        var streamChild = streams.child($userUID).child($streamUID);
        $scope.stream = {};
        $scope.reShares = {};
        $scope.isShared = false;
        streamChild.on('value', function(data){
            $scope.stream = data.val();
            $scope.users.$loaded().then(function(){
                 var userInfo = $scope.users.$getRecord($userUID);
                 $scope.stream.userInfo ={
                    fullname : userInfo.firstname + " " + userInfo.lastname,
                    photo : userInfo.photoUrl,
                    email : userInfo.email
                 } 
            })
            Utils.isImage($scope.stream.attached_file).then(function(result) {
                 $scope.stream.type = result? "image" : "video";
            });
            $scope.stream.uid = $userUID;
            $scope.stream.id = $streamUID;
            let reshareChild = reshares.child($streamUID);
            reshareChild.once('value', function(data){
              let $data = data.val();
              if($data){
                  $scope.isShared = true;
                  streams.child($data.user_id).child($data.post_id)
                  .once('value', function(data){
                      $scope.reShares = data.val();
                      Utils.isImage(data.val().attached_file).then(function(result) {
                           $scope.reShares['type'] = result? "image" : "video";
                      });
                  })
              }
            })
        })

        var likeChild = likes.child($streamUID);

        $scope.likes = {};

        likeChild.on('value', function(data){
            
            $scope.likes = data.val();
            
            if(!data.val()){
               return
            }
            
            let countLike = Object.keys($scope.likes).length;  
            var $htmlStr ='';

            $.each($scope.likes, function(key, item){
               if(item.uid === $rootScope.firebaseUser.uid){
                  $scope.likes['isLiked'] = true;  
               }
            })

            if(countLike > 0){
              $htmlStr += (countLike > 1? countLike + " Likes"  : countLike + " Like");
            }
           
            $scope.likes['noOfLikes'] = $htmlStr;
        })

        var shareChild = shares.child($streamUID);
        shareChild.on('value', function(data){

            $scope.shares = data.val();
            
            let countShare = Object.keys($scope.shares).length;  
            var $htmlStr ='';

            if(countShare > 0){
              $htmlStr += (countShare > 1? countShare + " Shares"  : countShare + " Share");
            }
           
            $scope.shares['noOfShares'] = $htmlStr;
        })

        var commentChild = comments.child($streamUID);
        
        commentChild.on('value', function(data){
            $scope.comments = [];
            
            $.each(data.val(), function(key, item){
              
              var $len = $scope.comments.length;
              $scope.comments.push(item);
              $scope.comments[$len]['key'] = key;
              
              Utils.isImage($scope.comments[$len]['attached_file']).then(function(result) {
                 $scope.comments[$len]['type'] = result? "image" : "video";
              });
              
              $scope.users.$loaded().then(function(){
                  var $userInfo = $scope.users.$getRecord(item.uid);
                   $scope.comments[$len]['user_info'] = {
                     fullname : $userInfo.firstname + " " + $userInfo.lastname,
                     photo : $userInfo.photoUrl,
                     email : $userInfo.email
                   }
              });

            })
        });

        mainFtry.getSymbolList().then(function(data){
             $scope.symbolData = data;
        })

        $scope.users.$loaded().then(function(data){
            angular.forEach(data, function(item, key){
              if(item.uid !== $rootScope.firebaseUser.uid){
                var $len = $scope.userData.length;
                $scope.userData.push({});
                $scope.userData[$len]['fullname'] = item.firstname + " " + item.lastname;
                $scope.userData[$len]['uid'] = item.uid;
                $scope.userData[$len]['photo'] = item.photoUrl; 
              }
            })
        })

        $scope.$watchlist = $firebaseArray(watchlist.child(firebaseUser.uid));
        $scope.$watchlist.$loaded().then(function(data){
           $scope.watchList = [];
           $.each(data, function(key, item){
               EODSvc.buildQuery({
                  symbol : item.stock
               }).fetch().then(function(data){
                  $scope.watchList[key] = data;
                  var symbolData = $filter('filter')($scope.symbolData, { 'symbol' : item.stock })[0];
                  $scope.watchList[key]['symbol'] = item.stock;
                  $scope.watchList[key]['name'] = symbolData.name;
                  let percentage = (data.change/data.previousClose) * 100;
                   $scope.watchList[key]['percentage'] = !isNaN(percentage)? (Math.abs(parseFloat(percentage).toFixed(2))) + "%" : "NA";
               }).catch(function(error){
                            console.log(error,"error");
               })       
           })
        })

        tags.on('value', function(data){
           
            let symbols = data.val();
            
            $scope.prospectList = []; 
            
            $.each(symbols, function(key, item){
                 let post = item['post'];
                 let comment = item['comment'];
                 let postCnt = post? Object.keys(post).length : 0;
                 let commentCnt = comment? Object.keys(comment).length : 0;
                 let overAllCnt = postCnt + commentCnt;
                 $scope.prospectList.push({
                     overAllCnt : overAllCnt,
                     symbol : key
                 })
            })

            let orderedData = $filter('orderBy')($scope.prospectList, 'overAllCnt', true);
            let trending = $filter('limitTo')(orderedData, 10);
            $scope.trending = [];
            $.each(trending, function(key, item){
                EODSvc.buildQuery({
                    symbol : item.symbol
                }).fetch().then(function(data){
                  $scope.trending[key] = data; 
                  var symbolData = $filter('filter')($scope.symbolData, { 'symbol' : item.symbol })[0];
                  $scope.trending[key]['symbol'] = symbolData.symbol;
                  $scope.trending[key]['name'] = symbolData.name;
                  let percentage = (data.change/data.previousClose) * 100;
                  $scope.trending[key]['percentage'] = !isNaN(percentage)? (Math.abs(parseFloat(percentage).toFixed(2))) + "%" : "NA";
                }).catch(function(error){
                  console.log(error,"error");
                })   
            })

        })

      }
      
   });

  $scope.showLikersAndSharers = function($id, option){
       $uibModal.open({
                  animation : true,
                  ariaLabelledBy : 'modal-title',
                  ariaDescribedBy : 'modal-body',
                  templateUrl : 'likersAndSharersModal.html',
                  controller : function($scope, $uibModalInstance, id){
                       
                       $scope.close = function(){
                           $uibModalInstance.dismiss("cancel");
                       };

                       $scope.userList = [];

                       $scope.options = option;

                       $scope.config = {
                          autoHideScrollbar: true,
                          theme: 'minimal-dark',
                          advanced:{
                            updateOnContentResize: true
                          },
                          scrollInertia: 0
                       };

                       $scope.setOptions = function(option){
                           $scope.userList = [];
                           let $data = option === 'likers'? $firebaseObject(likes.child(id)) : $firebaseObject(shares.child(id));
                           $data.$loaded().then(function(data){
                                angular.forEach(data, function(item, key){
                                    var $users = $firebaseArray(users);
                                    $users.$loaded().then(function(data){
                                       let checkIfExist = $filter('filter')($scope.userList ,{ uid : item.uid });
                                       if(!checkIfExist.length){
                                         let $userInfo = $users.$getRecord(item.uid);
                                         $scope.userList.push($userInfo);
                                         if(item.uid === $rootScope.firebaseUser.uid){
                                            $scope.userList[$scope.userList.length - 1]['lastname'] += "(You)"; 
                                         }
                                       }
                                    })
                                    
                                })
                          })       
                       };

                       $scope.setOptions($scope.options);

                  },
                  resolve: {
                    id : function () {
                      return $id;
                    }
                  }
                }).result.then(function () {
                  
                }, function () {
                   console.log('Modal dismissed at: ' + new Date());
                });
  };
  
  $scope.showRepostModal = function($stream){
       
       $uibModal.open({
                  animation : true,
                  ariaLabelledBy : 'modal-title',
                  ariaDescribedBy : 'modal-body',
                  templateUrl : 'repostStreamsModal.html',
                  controller : function($scope, $uibModalInstance, stream, streamChild, symbolData, userData){
                       
                       $scope.stream = {};
                       $scope.isPosting = false;
                       $scope.file = {};

                       $scope.repostData = stream;
                      
                       let streamArr = streamChild.child($rootScope.firebaseUser.uid);
                       let shareChild = shares.child(stream.id);
                       let reshareChild = null;
                       let pushKey = null;
                       let symbolArr = [];
                      
                       $scope.symbolData = symbolData;
                       $scope.userData = userData;
                       
                       $scope.close = function(){
                           $uibModalInstance.dismiss("cancel");
                       };

                       $scope.closeImage = function($evt){
                            
                            $evt.preventDefault();
                            
                            if($scope.isPosting){
                                return false;  
                            }

                            $scope.file = {
                              isLoaded : false,
                              src : ""
                            };
                       };

                       $scope.savePost = function(){
                          
                           $scope.isPosting = true;

                           angular.element( "#rePostTxArea [data-atwho-at-query^='$'] .text" ).each(function( index ) {
                              var $symbol = $(this).text();
                              if($.inArray( $symbol , symbolArr ) === -1){
                                 symbolArr.push($symbol);
                              }
                           });

                           let $file = $scope.file.data;
                           pushKey = streamArr.push().key;
                           reshareChild = reshares.child(pushKey);
                           
                           if($file){              
                              var $filesRef = FirebaseStorageRef.child('attachfiles').child('post').child(stream.id);
                              var $uploadTask = $filesRef.put($file);
                              $uploadTask.on('state_changed', function(snapshot){
                                
                                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                                console.log('Upload is ' + progress + '% done');
                                switch (snapshot.state) {
                                  case firebase.storage.TaskState.PAUSED: // or 'paused'
                                    console.log('Upload is paused');
                                    break;
                                  case firebase.storage.TaskState.RUNNING: // or 'running'
                                    console.log('Upload is running');
                                    break;
                                }

                              }, function(error) {
                                
                                switch (error.code) {
                                  case 'storage/unauthorized':
                                    // User doesn't have permission to access the object
                                    break;

                                  case 'storage/canceled':
                                    // User canceled the upload
                                    break;

                                  case 'storage/unknown':
                                    // Unknown error occurred, inspect error.serverResponse
                                    break;
                                }

                                 onError();  

                              }, function() {
                                  var downloadURL = $uploadTask.snapshot.downloadURL;
                                  onSave(downloadURL);
                              });
                            }else{
                              onSave("");
                            }
                       }


                       var onSave = function(attachFileUrl){
                            streamArr.child(pushKey).set({ 
                                post: $scope.stream.post,
                                attached_file : attachFileUrl,
                                timestamp : firebase.database.ServerValue.TIMESTAMP,
                            }).then(function(){
                                onShare();
                            }).catch(function(error){
                                onError();
                            })
                       };

                       var onShare = function(){
                            shareChild.push().set({
                                uid : $rootScope.firebaseUser.uid,
                                timestamp : firebase.database.ServerValue.TIMESTAMP,
                            }).then(function(){
                                onReshare();
                            }).catch(function(error){
                                onError();
                            })
                       };

                       var onReshare = function(){
                            reshareChild.set({
                                user_id : stream.uid,
                                post_id : stream.id,
                                timestamp : firebase.database.ServerValue.TIMESTAMP,
                            }).then(function(){
                                if(symbolArr.length > 0){
                                    onTagSave(pushKey);
                                }else{
                                    onSuccess();
                                }
                            }).catch(function(error){
                                onError();
                            })
                       };

                       var onTagSave = function(post_id){
                             let success = true;
                             console.log(symbolArr,"symbolArr")
                             $.each(symbolArr, function(key, item){
                                
                                tags.child(item).child("post").push().set({
                                    post_id : post_id
                                }).then(function(){
                                    
                                }).catch(function(error){
                                    success = false;
                                })

                                if(!success){
                                    return false
                                }
                            })

                            if(success){
                               onSuccess();
                            }else{
                               onError();
                            }
                       }

                       var onError = function(){
                            $scope.isPosting = false;
                       };

                       var onSuccess = function(){
                            $scope.isPosting = false;
                            $uibModalInstance.close();
                       };

                  },
                  resolve: {
                    stream : function () {
                      return $stream;
                    },
                    streamChild : function(){
                      return streams;
                    },
                    symbolData : function(){
                      return $scope.symbolData;
                    },
                    userData : function(){
                        return $scope.userData;
                    }
                  }
                }).result.then(function () {
                   toastr.success('Success','Stream has been reposted');
                }, function () {
                   console.log('Modal dismissed at: ' + new Date());
                });
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

  $scope.config = {
        autoHideScrollbar: true,
        theme: 'minimal-dark',
        advanced:{
          updateOnContentResize: true
        },
        scrollInertia: 0
  };

  $scope.$streams = {
      $variable : {
        showCommentList : false,
        comments : {
           text : "",
           file : { isLoaded : null },
           noOfDigits : null,
           isPosting : false
        }
      },
      $share : function(provider, path){
        
          Socialshare.share({
  		       'provider': provider,
  		       'attrs': {
  		        'socialshareUrl' : Config.BaseUrl + "/stream/" + path 
  		       }
  		    });

      },
      $closeCommentImage : function($ev){
       $ev.preventDefault();
       var self = this;
       if(self.$variable.comments.isPosting){
           return;
       }
       self.$variable.comments.file = {
          isLoaded : null
       }
      },
      $postComment : function(id){
        
        var self = this;

        var symbolArr = [];
        
        angular.element( "#commentArea [data-atwho-at-query^='$'] .text" ).each(function( index ) {
            var $symbol = $(this).text();
            if($.inArray( $symbol , symbolArr ) === -1){
               symbolArr.push($symbol);
            }
        });

        var $file = self.$variable.comments.file.data;
        self.$variable.comments.isPosting = true;
        var commentsChild = comments.child(id);
        var pushKey = commentsChild.push().key;
        if($file){
            var $filesRef = FirebaseStorageRef.child('attachfiles').child('comment').child(pushKey);
            var $uploadTask = $filesRef.put($file);
            $uploadTask.on('state_changed', function(snapshot){
              // Observe state change events such as progress, pause, and resume
              // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
              var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
              console.log('Upload is ' + progress + '% done');
              switch (snapshot.state) {
                case firebase.storage.TaskState.PAUSED: // or 'paused'
                  console.log('Upload is paused');
                  break;
                case firebase.storage.TaskState.RUNNING: // or 'running'
                  console.log('Upload is running');
                  break;
              }
            }, function(error) {
              // Handle unsuccessful uploads
              
              // A full list of error codes is available at
              // https://firebase.google.com/docs/storage/web/handle-errors
              switch (error.code) {
                case 'storage/unauthorized':
                  // User doesn't have permission to access the object
                  break;

                case 'storage/canceled':
                  // User canceled the upload
                  break;

                case 'storage/unknown':
                  // Unknown error occurred, inspect error.serverResponse
                  break;
              }

              onError();

            }, function() {
              // Handle successful uploads on complete
              // For instance, get the download URL: https://firebasestorage.googleapis.com/...
              var downloadURL = $uploadTask.snapshot.downloadURL;
              onSave(downloadURL);
                
            });
        }else{
           onSave("");
        }
            
      

        function onSuccess(){
           self.$variable.comments.isPosting = false; 
           self.$variable.comments.text = "";
           self.$variable.comments.file = {
              isLoaded : null
           }
        }

        function onError(){
           self.$variable.isPosting = false;
        }

        function onSave(attached_file) {
          commentsChild.child(pushKey).set({
             post : self.$variable.comments.text,
             attached_file : attached_file,
             uid : $rootScope.authenticatedUser.uid,
             timestamp : firebase.database.ServerValue.TIMESTAMP
          }).then(function(){
              if(symbolArr.length > 0){
                    onTagSave(pushKey);
              }else{
                    onSuccess();
              }
          }).catch(function(error){
              onError();
          })
        }

        function onTagSave(comment_id){
             let success = true;
             $.each(symbolArr, function(key, item){
                
                tags.child(item).child("comment").push().set({
                    comment_id : comment_id
                }).then(function(){
                    
                }).catch(function(){
                    success = false;
                })

                if(!success){
                    return false
                }
            })

            if(success){
               onSuccess();
            }else{
               onError();
            }
        }


      },
      $cancelComment : function(){
        var self = this;
        self.$variable.comments.isPosting = false; 
        self.$variable.comments.text = "";
        self.$variable.comments.file = {
          isLoaded : null
        }
      },
      $likePost : function(id){

        var self = this;
        var likeChild = likes.child(id);
        var $likeArray = $firebaseArray(likeChild);
        var $uid = $rootScope.authenticatedUser.uid;
        var isAlreadyLikeKey = null;
        
        $likeArray.$loaded().then(function(data){
             angular.forEach(data, function(like, key){
                  if(like.uid === $uid){
                      isAlreadyLikeKey = like.$id;
                      likeChild.child(isAlreadyLikeKey).remove();
                  }
             });
             if(!isAlreadyLikeKey){
                var pushKey = likeChild.push().key;
                likeChild.child(pushKey).set({
                    uid : $uid ,
                    timestamp : firebase.database.ServerValue.TIMESTAMP
                }).then(function(){
                });
             }
        })


      },
      $retrieve : function(){
        var self = this;
        streamsFtry.getPost().then(function(data){
          self.$variable.list = data;
          console.log(self.$variable.list, "data");
        }).catch(function(error){
          console.log(error, "error");
        });
      },
      $savePost : function(form){
        
        // streamsFtry.createPost(data).then(function(data){
        //   console.log(data, "data");
          
       
        // }).catch(function(error){
        //   console.log(error, "error");
          
        // });
     },
     $setError : function(form,field){
          if(form[field].$invalid && (form[field].$dirty || form[field].$touched || form.$submitted)){
              return true;
          }
          return false;
     },
     $checkTextLength : function($ev){
            //console.log($ev.shiftKey, $ev.keyCode)
            
            var $textCounter = angular.element(".textCounter");
            var $textCounterLen = 140;
            var $postVal = angular.element($ev.currentTarget).val();
            var $postLen = $postVal? $postVal.length : 0;
            var $remainingPostLen = $textCounterLen - $postLen;
            $textCounter.text($remainingPostLen);
            var self = this;
            self.$variable.noOfDigits = $textCounter.text().length;    
     }     
   };

    $scope.symbolClick = function(symbol){
       var symbolData = $filter('filter')($scope.symbolData, { 'symbol' : symbol })[0];
       store.set('symbolData', symbolData);
       $window.location.href = "/stock/symbol/" + symbol;
    }

    $scope.mentionClick = function(uid){
       $scope.users.$loaded().then(function(data){
           var userData = $scope.users.$getRecord(uid);
           store.set('userData', userData);
           $window.location.href = "/users/" + userData.firstname + userData.lastname; 
       })
    }

    return $scope.init();



})