'use strict';

asxTradeTalkApp.controller('stockDetailCtrl', function($scope, $uibModal, Config, EODSvc, $compile, Auth, moment, store, $window, $firebaseObject, $ngConfirm, Utils, Socialshare, $filter, $q, $timeout, mainFtry, $firebaseArray, FirebaseDatabase, FirebaseStorageRef, $rootScope, toastr){
  
   console.log('stockDetailCtrl', store.get('symbolData'))

   $scope.selectedSymbol = store.get('symbolData');

   $scope.symbolDetails = [];

   $scope.isDetailLoads = false;

   EODSvc.buildQuery({
     symbol : $scope.selectedSymbol.symbol
   }).fetch().then(function(data){
      $scope.symbolDetails = data;
      $scope.symbolDetails['symbol'] = $scope.selectedSymbol.symbol;
      $scope.symbolDetails['name'] = $scope.selectedSymbol.name;
      $scope.symbolDetails['sector'] = $scope.selectedSymbol.sector;
      let percentage = (data.change/data.previousClose) * 100;
      $scope.symbolDetails['percentage'] = !isNaN(percentage)? (Math.abs(parseFloat(percentage).toFixed(2))) + "%" : "NA";
      $scope.isDetailLoads = true;
   }).catch(function(error){
      console.log(error,"error");
   })


   $scope.init = function(){
      $scope.$streams.$init();
   };

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
   $scope.watchData = {};
   $scope.watchers = 0;
  
   Auth.$onAuthStateChanged(function(firebaseUser) {
      if(firebaseUser){
      
        streams.on('value', function(data){
            $loadStreams(firebaseUser.uid);
            $loadReshares();
        });

        likes.on('value', function(data){
            $loadLikes(); 
        })

        shares.on('value', function(data){
            $loadShares();
        })

        comments.on('value', function(data){
            $loadComments();
        });

        watchlist.on('value', function(data){
            $scope.watchers = 0;
            $.each(data.val(), function(key, item){
                $.each(item, function(key, item){
                   if(item.stock == $scope.selectedSymbol.symbol){
                        $scope.watchers++;
                   }
                })
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
 
       
        let selectSym = $scope.selectedSymbol.symbol;
        $scope.$watchlist = $firebaseArray(watchlist.child(firebaseUser.uid));
        $scope.$watchlist.$watch(function(){
           $scope.watchData = {};
           $scope.$watchlist.$loaded().then(function(data){
               getWatchList(data);
               $.each(data, function(key, item){
                   if(item.stock === selectSym){
                      $scope.watchData = item;
                      return false;
                   }
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

   var getWatchList = function(data){
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
   }

   var $loadStreams = function(uid){
        let selectSym = $scope.selectedSymbol.symbol;
        let tagPosts = tags.child(selectSym).child('post');
        let tagPostsArr = $firebaseArray(tagPosts);
        $scope.$streams.$variable.list = [];
        $scope.streams.$loaded().then(function(data){
              angular.forEach(data, function(stream, key){
                   var streamUID = stream.$id;
                   angular.forEach(stream, function(inStream, key){
                      if(inStream){
                          let postId = key;
                          let isAdded = false;
                          tagPostsArr.$loaded().then(function(data){
                              
                              $.each(data, function(key, item){
                                   if(item.post_id === postId){
                                       isAdded = true;
                                       return false;
                                   }
                              })

                              if(typeof inStream === 'object' && streamUID != uid && isAdded){

                                    var len = $scope.$streams.$variable.list.length; 
                                    $scope.$streams.$variable.list.push(inStream);
                                    $scope.$streams.$variable.showCommentList[len] = false;
                                    $scope.$streams.$variable.comments.file[len] = {
                                       isLoaded : false
                                    }
                                    $scope.$streams.$variable.list[len]['id'] = key;
                                    $scope.$streams.$variable.list[len]['uid'] = streamUID;
                                    $scope.$streams.$variable.list[len]['timestamp'] = parseInt(inStream.timestamp);
                                    Utils.isImage(inStream.attached_file).then(function(result) {
                                         $scope.$streams.$variable.list[len]['type'] = result? "image" : "video";
                                    });
                                    $loadLikes(); 
                                    $scope.users.$loaded().then(function(){
                                      var userInfo = $scope.users.$getRecord(streamUID);
                                      $scope.$streams.$variable.list[len]['userInfo'] = {
                                          fullname : userInfo.firstname + " " + userInfo.lastname,
                                          photo : userInfo.photoUrl,
                                          email : userInfo.email
                                      };
                                    });
                              }
                          })
                      }
                   })
              })
        })
   };

   var $loadLikes = function(){

       $scope.streams.$loaded().then(function(data){
          $timeout(function(){
            $scope.likes = [];
            var data = $scope.$streams.$variable.list;
            angular.forEach(data, function(data, key){
                //console.log(data,"data")
                let $likes = $firebaseObject(likes.child(data.id));
                let $id = data.id;
                 $likes.$loaded().then(function(data){
                    //console.log(data,"data")
                    let countLike = 0;  
                    var $htmlStr ='';
                    
                    $scope.likes[$id] = {};
                    
                    $scope.likes[$id]['isLiked'] = false;
                    
                    angular.forEach(data, function(like, key){
                          countLike++;
                          if(like.uid === $rootScope.firebaseUser.uid){
                            $scope.likes[$id]['isLiked'] = true;  
                          }
                    })
                    
                    if(countLike > 0){
                      $htmlStr += (countLike > 1? countLike + " Likes"  : countLike + " Like");
                    }
                   
                    $scope.likes[$id]['noOfLikes'] = $htmlStr;
                 });
            })  
          })
       });

  };

  var $loadShares = function(){

      $scope.streams.$loaded().then(function(data){
          $timeout(function(){
            $scope.shares = [];
            var data = $scope.$streams.$variable.list;
            angular.forEach(data, function(data, key){
                //console.log(data,"data")
                let $shares = $firebaseObject(shares.child(data.id));
                let $id = data.id;
                 $shares.$loaded().then(function(data){
                    //console.log(data,"data")
                    let countShare = 0;  
                    var $htmlStr ='';
                    
                    $scope.shares[$id] = {};
                    
                    angular.forEach(data, function(like, key){
                          countShare++;
                    })
                    
                    if(countShare > 0){
                      $htmlStr += (countShare > 1? countShare + " Shares"  : countShare + " Share");
                    }
                   
                    $scope.shares[$id]['noOfShares'] = $htmlStr;
                 });
            })  
          }, 1000)
      });

  };

  var $loadReshares = function(){
       $scope.streams.$loaded().then(function(data){
          $timeout(function(){
            $scope.reShares = [];
            var data = $scope.$streams.$variable.list;
            angular.forEach(data, function(data, key){
                //console.log(data,"data")
                let $id = data.id;
                let reshareChild = reshares.child($id);
                reshareChild.once('value', function(data){
                   console.log(data.val(),"data")
                   let $data = data.val();
                   if($data){
                      streams.child($data.user_id).child($data.post_id)
                      .once('value', function(data){
                          $scope.reShares[$id] = data.val();
                          Utils.isImage(data.val().attached_file).then(function(result) {
                               $scope.reShares[$id]['type'] = result? "image" : "video";
                          });
                      })

                   }
                })
            })  
          }, 1000)
      });
  }

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

  var $loadComments = function(){
     
      $scope.streams.$loaded().then(function(data){
        $timeout(function(){
          $scope.comments = [];
          console.log($scope.$streams.$variable.list)
          angular.forEach($scope.$streams.$variable.list, function(data, key){
             let $comments = comments.child(data.id);
             let $post_id = data.id;
             $comments.on('value', function(data){
                if(data.val()){

                    $scope.comments[$post_id] = [];
                    angular.forEach(data.val(), function(data, key){
                          var $len = $scope.comments[$post_id].length;
                          $scope.comments[$post_id].push(data);
                          $scope.comments[$post_id][$len]['key'] = key;
                          Utils.isImage($scope.comments[$post_id][$len]['attached_file']).then(function(result) {
                              $scope.comments[$post_id][$len]['type'] = result? "image" : "video";
                          });
                          $scope.users.$loaded().then(function(){
                            var $userInfo = $scope.users.$getRecord(data.uid);
                             $scope.comments[$post_id][$len]['user_info'] = {
                               fullname : $userInfo.firstname + " " + $userInfo.lastname,
                               photo : $userInfo.photoUrl,
                               email : $userInfo.email
                             }
                          })
                         
                    })
                } 
             })
          })
        }, 1000)  
      })
  };


  $scope.watchSymbol = function(symbol){
      watchlist.child($rootScope.firebaseUser.uid).push().set({
          stock : symbol
      }).then(function(){
         $ngConfirm({
             title : 'Stock Watched',
             content : '<strong>' + symbol + '</strong> has been added to your watchlist.',
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
  };

  $scope.unWatchSymbol = function(symbolData){
       $scope.$watchlist.$remove(symbolData).then(function(){
           $ngConfirm({
             title : 'Stock Unwatched',
             content : '<strong>' + symbolData.stock + '</strong> has been removed to your watchlist.',
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
  };

  $scope.isObjectEmpty = function(data){
    return Object.keys(data).length === 0;
  }

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
      $field : {
         post : null,
         user_id : null,
         like : 0,
         attached_file : "",
      },
      $variable : {
        list : [],
        file : { isLoaded : null },
        isPosting : false,
        noOfDigits : 3,
        pushKey : null,
        showCommentList : [],
        comments : {
           text : [
           ],
           file : [
           ],
           noOfDigits : [
           ],
           isPosting : [
           ]
        }
      },
      $init : function(){
          var self = this;
          let selectSym = $scope.selectedSymbol.symbol;
          self.$field.post = '<span class="atwho-inserted ng-scope" data-atwho-at-query="$'+ selectSym+'" contenteditable="false"><strong class="text" ng-click="symbolClick(\''+ selectSym +'\')">'+ selectSym +'</strong></span';
          self.$field.user_id = null;
          self.$field.attached_file = "";
          self.$variable.file = {
            isLoaded : null
          };
          self.$variable.isPosting = false;
      },
      $share : function(provider, path){
        
          Socialshare.share({
             'provider': provider,
             'attrs': {
              'socialshareUrl' : Config.BaseUrl + "/stream/" + path 
             }
          });

      },
      $save : function(){
      
        var self = this;
        
        var symbolArr = [];
        
        angular.element( "#postArea [data-atwho-at-query^='$'] .text" ).each(function( index ) {
            var $symbol = $(this).text();
            if($.inArray( $symbol , symbolArr ) === -1){
               symbolArr.push($symbol);
            }
        });

        var $file = self.$variable.file.data;
        self.$field.user_id = $rootScope.authenticatedUser.uid;
        self.$variable.isPosting = true;
        var data = self.$field;
        var uid = data.user_id;
        var streamChild = streams.child(uid);
        var pushKey = streamChild.push().key;   
        if($file){              
          var $filesRef = FirebaseStorageRef.child('attachfiles').child('post').child(pushKey);
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
            
       

        function onSuccess(){
             self.$variable.isPosting = false; 
             self.$init();
        }

        function onError(){
              self.$variable.isPosting = false;
        }

        function onSave(attached_file){
            streamChild.child(pushKey).set({
             post : data.post,
             attached_file : attached_file,
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

        function onTagSave(post_id){
             let success = true;
             $.each(symbolArr, function(key, item){
                
                tags.child(item).child("post").push().set({
                    post_id : post_id
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
      $closeImage : function($ev){
       $ev.preventDefault();
       var self = this;
       if(self.$variable.isPosting){
           return;
       }
       self.$variable.file = {
          isLoaded : null
       }
      },
      $closeCommentImage : function($ev, $index){
       $ev.preventDefault();
       var self = this;
       if(self.$variable.comments.isPosting[$index]){
           return;
       }
       self.$variable.comments.file[$index] = {
          isLoaded : null
       }
      },
      $postComment : function($index, id){
        
        var self = this;

        var symbolArr = [];
        
        angular.element( "#commentArea_" + $index + " [data-atwho-at-query^='$'] .text" ).each(function( index ) {
            var $symbol = $(this).text();
            if($.inArray( $symbol , symbolArr ) === -1){
               symbolArr.push($symbol);
            }
        });

        var $file = self.$variable.comments.file[$index].data;
        self.$variable.comments.isPosting[$index] = true;
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
           self.$variable.comments.isPosting[$index] = false; 
           self.$variable.comments.text[$index] = "";
           self.$variable.comments.file[$index] = {
              isLoaded : null
           }
        }

        function onError(){
           self.$variable.isPosting = false;
        }

        function onSave(attached_file) {
          commentsChild.child(pushKey).set({
             post : self.$variable.comments.text[$index],
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
      $cancelComment : function($index){
        var self = this;
        self.$variable.comments.isPosting[$index] = false; 
        self.$variable.comments.text[$index] = "";
        self.$variable.comments.file[$index] = {
          isLoaded : null
        }
      },
      $likePost : function(id, $index){

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
 