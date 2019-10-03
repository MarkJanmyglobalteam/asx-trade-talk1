var asxTradeTalkApp = angular.module('asxTradeTalkApp',
	[
	'slickCarousel',
  'angularMoment',
  'chart.js',
  'zingchart-angularjs',
  'ngSanitize',
  'ui.select',
  'ui.bootstrap',
  'satellizer',
  'ngMessages',
  'angular-storage',
  'ngPasswordStrength',
  'angular-jwt',
  'firebase',
  '720kb.socialshare',
  'ngAnimate',
  'toastr',
  'ngScrollbars',
  'cp.ngConfirm',
  'ngclipboard',
  'angular-storage',
  'rx'
	])

  .config(function($interpolateProvider, $authProvider, $httpProvider, jwtOptionsProvider, jwtInterceptorProvider, slickCarouselConfig, ChartJsProvider, Config){
   
    //interpolateProvider
    $interpolateProvider.startSymbol('{[{');
    $interpolateProvider.endSymbol('}]}');
    
    //slickCarousel
    slickCarouselConfig.dots = true;
    slickCarouselConfig.autoplay = false;
    
    //Satellizer Provider
    $authProvider.loginUrl = Config.BaseUrl + '/api/authentication/login';
    $authProvider.tokenPrefix = "fe_access"

    //ChartJs
    // Configure all charts
    ChartJsProvider.setOptions({
      chartColors: ['#FF5252', '#FF8A80'],
      responsive: true
    });
    
    // Configure all line charts
    ChartJsProvider.setOptions('line', {
      showLines: false
    });

    //  $httpProvider.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
    //  $httpProvider.defaults.headers.common["Access-Control-Allow-Headers"] = "Content-Type, Authorization";
    // console.log($httpProvider.defaults.headers.common["Access-Control-Allow-Headers"], "fsdgs")


})

.run(function(authManager, $rootScope, $firebaseObject, $auth, $timeout, jwtHelper, store, Auth, Ref, $window, Config, $firebaseArray, toastrConfig, FirebaseStorageRef){
    
    // any time auth state changes, add the user data to scope
    $rootScope.isSigningUp = false;
    Auth.$onAuthStateChanged(function(firebaseUser) {
       $rootScope.firebaseUser = firebaseUser;
       var $loginUrl = Config.BaseUrl + "/login";
       var $homeUrl = Config.BaseUrl + "/";
       var $currentUrl = $window.location.href;

       if(firebaseUser){
           let userData = Ref.child('userData').child(firebaseUser.uid);
           userData.on('value', function(data){
             $rootScope.authenticatedUser = data.val();
             $rootScope.authenticatedUser.provider = firebaseUser.providerData[0]['providerId'];
           })
       }
       
       if(firebaseUser && $currentUrl === $loginUrl && !$rootScope.isSigningUp){
           goTo($homeUrl);
       }else if (!firebaseUser && $currentUrl !== $loginUrl){
           goTo($loginUrl);
       }

       function goTo(link){
          $window.location.href = link;
       }

    }); 

    $rootScope.isOpen = false;
    $rootScope.open = function(open){
         $rootScope.isOpen = !open;
          console.log($rootScope.isOpen,"isOpen");
    };

     angular.extend(toastrConfig, {
      autoDismiss: true,
      timeOut: 1000,
      containerId: 'toast-container',
      maxOpened: 0,    
      newestOnTop: true,
      positionClass: 'toast-top-center',
      preventDuplicates: false,
      preventOpenDuplicates: false,
      target: 'body',
      allowHtml: true,
    });
    
})


.controller('mainCtrl', function($uibModal, $log, $filter, userList, StockSvc, Config, $scope, $auth, $timeout, mainFtry, $window, $rootScope,  moment, store, Auth, Ref, $firebaseObject, $firebaseArray,toastr, FirebaseDatabase, $firebaseStorage, FirebaseStorageRef, EODSvc){
    
      
      $rootScope.isDoneSearching = false;

      $scope.init = function(){
         $scope.$main.$init();
      };

      $scope.config = {
        autoHideScrollbar: true,
        theme: 'minimal-dark',
        advanced:{
          updateOnContentResize: true
        },
        scrollInertia: 0
      };

      $scope.symbolList = [];
      mainFtry.getSymbolList().then(function(data){
          $scope.symbolList = data;
      })
      

      $scope.userList = [];
      userList.$loaded().then(function(data){
          $scope.userList = data;
      })

      var tags = FirebaseDatabase.ref("tags"); 
      tags.on('value', function(data){
          let prospectTrend = [];
          
          $.each(data.val(), function(key, item){
                //console.log(key, item)
                let post = item.post;
                let comment = item.comment;
                let postCnt = post? Object.keys(post).length : 0;
                let commentCnt = comment? Object.keys(comment).length : 0;
                let overAllCnt = postCnt + commentCnt;
                prospectTrend.push({
                     overAllCnt : overAllCnt,
                     symbol : key
                });
          })
          
          let orderedData = $filter('orderBy')(prospectTrend, 'overAllCnt', true);
          let trending = $filter('limitTo')(orderedData, 10);
          $scope.mainTrending = [];
          $.each(trending, function(key, item){
              EODSvc.buildQuery({
                  symbol : item.symbol
              }).fetch().then(function(data){
                $scope.mainTrending[key] = data; 
                var symbolData = $filter('filter')($scope.symbolList, { 'symbol' : item.symbol })[0];
                $scope.mainTrending[key]['symbol'] = symbolData.symbol;
                $scope.mainTrending[key]['name'] = symbolData.name;
                let percentage = (data.change/data.previousClose) * 100;
                $scope.mainTrending[key]['percentage'] = !isNaN(percentage)? (Math.abs(parseFloat(percentage).toFixed(2))) + "%" : "NA";
              }).catch(function(error){
                console.log(error,"error");
              })   
          })

      })

      $scope.empty = {

      };

      $scope.gotoSearchPage = function(searchStr){
        if(!searchStr){
           return;
        }
        $window.location.href = "/search?query=" + searchStr;
      };

      $scope.searchFnc = function(searchStr){
         $scope.searchKey = searchStr.charAt(0);
      };

      $scope.gotoSymbol = function(symbol){
         let symbolData = { name : symbol.name, symbol : symbol.symbol, sector : symbol.sector};
         store.set('symbolData', symbolData);
         $window.location.href = "/stock/symbol/" + symbol.symbol;
      };

      $scope.gotoUser = function(user){
         let userData = user;
         store.set("userData", userData);
         $window.location.href = "/users/" + userData.firstname + userData.lastname; 
      };

      $scope.filters = { 
            users : function(item){
              if($scope.searchKey === "@" || $scope.searchKey !== "$"){
                  var $searchTxt = $scope.searchString;
                  if($scope.searchKey === "@"){
                    $searchTxt = $searchTxt.substring(1);
                  }
                  var $firstname = item.firstname.toLowerCase();
                  var $lastname = item.lastname.toLowerCase();
                  if($searchTxt){
                      $searchTxt = $searchTxt.toLowerCase();
                      var fullDetails = $firstname + " " + $lastname;
                      if(fullDetails.match($searchTxt)){

                          return true;
                      }
                      return false;
                  }
                  return true;
              }
           },
           symbols : function(item){
              if($scope.searchKey === "$" || $scope.searchKey !== "@"){
                var $searchTxt = $scope.searchString;
                if($scope.searchKey === "$"){
                    $searchTxt = $searchTxt.substring(1);
                }
                var $symbol = item.symbol.toLowerCase();
                if($searchTxt){
                    $searchTxt = $searchTxt.toLowerCase();
                    if($symbol.match($searchTxt)){

                        return true;
                    }
                    return false;
                }
                return true;
              }
           }
      }

      $scope.$main = {
          $variable : {
             isAuthenticated : false,
          },
          $init : function(){
               var self = this;
               self.$variable.isAuthenticated = $auth.getToken()? true : false; 
               self.$variable.profile = {};
          },
          $profile : function(){
               var $users = FirebaseDatabase.ref("userData").child($rootScope.authenticatedUser.uid);
               $users.once('value', function(data){
                  let userData = data.val();
                  store.set("userData", userData);
                  $window.location.href = "/users/" + userData.firstname + userData.lastname; 
               })
          },
          $logout : function(){
               Auth.$signOut();
               $window.location.href="/login";
          },
          $settings : function(){
                
                let userData = $rootScope.authenticatedUser;
                
                $uibModal.open({
                  animation : true,
                  ariaLabelledBy : 'modal-title',
                  ariaDescribedBy : 'modal-body',
                  templateUrl : 'profileModal.html',
                  controller : function($scope, $uibModalInstance, user){
                   
                      var userData = FirebaseDatabase.ref("userData").child(user.uid);
                
                      $scope.profile = user;
                      $scope.file = {
                        src : user.photoUrl
                      };

                      $scope.pword = {

                      };

                      $scope.close = function(){
                           $uibModalInstance.dismiss('cancel');
                      }

                      var onSave = function(column){
                          let col = column;
                          var data = $scope.profile[column];
                          userData.update({ 
                             [col] : data 
                          }).then(function(){
                              toastr.success('Information has been updated.', 'Success');
                              $scope[column + "Disabled"] = true; 
                          }).catch(function(error){
                              toastr.error('Opss.. Something went wrong.' , 'Error');
                              console.log(error,"error")
                          });
                      }
                     
                      $scope.updateRecord = function(column){
                          
                          var data = $scope.profile[column];
                          var $el = angular
                             .element("input[name='"+ column +"']")
                             .closest(".input-group");
                          var condition = $scope[column + "Edit"];
                          $scope[column + "Disabled"] = false;
                          
                          if(!data){
                             $el.addClass("has-error");
                             $scope[column + "Edit"] = false;
                             return 
                          }

                          $el.removeClass("has-error");
                          
                          if(condition){
                              onSave(column); 
                          }   
                      };

                      $scope.updateEmail = function(column){

                          var data = $scope.profile[column];
                          var $el = angular
                             .element("input[name='"+ column +"']")
                             .closest(".input-group");
                          var condition = $scope[column + "Edit"];
                          $scope[column + "Disabled"] = false;
                          
                          if(!data || !validateEmail(data)){
                             $el.addClass("has-error");
                             $scope[column + "Edit"] = false;
                             return 
                          }

                          $el.removeClass("has-error");

                          if(condition){
                              $scope.isLoading = true;
                              Auth.$updateEmail(data).then(function() {
                                  userData.update({ 
                                     'email' : data 
                                  }).then(function(){
                                      toastr.success('Information has been updated.', 'Success');
                                      onSuccess();
                                  }).catch(function(error){
                                      onError();
                                      toastr.error('Opss.. Something went wrong.' , 'Error');
                                      console.log(error,"error")
                                  });
                              }).catch(function(error){
                                  onError();
                                  toastr.error(error.message , 'Error');
                                  console.log(error,"error")
                              });
                          } 

                          function onSuccess(){
                              $scope[column + "Disabled"] = true; 
                              $scope.isLoading = false;
                          }

                          function onError(){
                              $scope.isLoading = false;
                              $scope[column + "Edit"] = true;
                          }  
                      }

                      $scope.verifyPassword = function(){
                         
                          let verifiedPword;
                          verifiedPword = $scope.pword.verified;
                          console.log(verifiedPword,"verifiedPword")
                          let $elVPword;

                          $elVPword = angular.element("#verifiedPword");

                          if(!verifiedPword){
                             $elVPword.addClass("has-error");
                             return;
                          }

                          var emailAuthProvider = firebase.auth.EmailAuthProvider;
                          var currentUser = firebase.auth().currentUser;
                          var credential = emailAuthProvider.credential(currentUser.email, verifiedPword);

                          $elVPword.removeClass("has-error");
                          $scope.isVerifying = true;
                          
                          currentUser.reauthenticate(credential).then(function(){
                                $scope.isVerifying = false;
                                $scope.editPassword = true;
                                $scope.editVerifiedPword = false;
                                $scope.$apply();
                          }).catch(function(error){
                                $elVPword.addClass("has-error");
                                toastr.error('Password Invalid.' , 'Error');
                                $scope.isVerifying = false;
                          });
                      }

                      $scope.updatePassword = function(){

                          let password, retype;
                          password = $scope.password;
                          retype = $scope.retype;
                          let $elPword, $elRetype;
                          let passCondition = true, retypeCondition = true;
                          
                          $elPword = angular.element("#password");
                          $elRetype = angular.element("#retype");

                          $elPword.removeClass("has-error");
                          $elRetype.removeClass("has-error");
                          
                          if(!password){
                             $elPword.addClass("has-error");
                             passCondition = false;
                          }

                          if(!retype || (retype !== password)){
                             $elRetype.addClass("has-error");
                             retypeCondition = false;
                          }

                        

                          if(passCondition && retypeCondition){
                              $scope.isPassLoading = true;
                              Auth.$updatePassword(password).then(function() {
                                 $scope.isPassLoading = false;
                                 $scope.editPassword = false;
                                 toastr.success('Information has been updated.', 'Success');
                              }).catch(function(error) {
                                 toastr.error(error.message , 'Error');
                                 $scope.isPassLoading = false;
                              });
                          }
                      }

                      var validateEmail = function(email) {
                        var expression = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
                        if (expression.test(email)) {
                          return true;
                        }else {
                          return false;
                        }
                      };

                      $scope.saveImage = function(){
                            
                            var $filesRef = FirebaseStorageRef.child('profileimages').child(user.uid);

                            $scope.isUpdating = true;

                            var $uploadTask = $filesRef.put($scope.file.data);
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

                                $scope.isUpdating = false;
                                $scope.$apply(); 

                            }, function() {
                                var downloadURL = $uploadTask.snapshot.downloadURL;
                                $scope.profile.photoUrl = downloadURL;
                                $scope.isUpdating = false;
                                onSave("photoUrl");
                            });



                      }


                  },
                  resolve: {
                    user : function () {
                      return userData;
                    }
                  }
                }).result.then(function () {
                }, function () {
                  $log.info('Modal dismissed at: ' + new Date());
                });
          }
          
     };

     return $scope.init();

})

.factory('mainFtry', function($http, $q, Config){
  return {
    getSymbolList : function(){
      var deferred = $q.defer();
      $http({
        url: Config.BaseUrl + "/app/companyList.json",
        method: 'GET',
      }).then(function(response) {
        deferred.resolve(response.data);
      }, function(response){
        deferred.reject(response);
      });

      return deferred.promise;
    }
 }
})

.service("EODSvc", function($http, $q){

  this.BASE_URL = 'https://cors-anywhere.herokuapp.com/https://eodhistoricaldata.com/api/real-time/';
  this.API_TOKEN = '5a4c5a8b13c90';
  this.query = '';

  this.buildQuery = function(data){
        let params = {
          api_token : this.API_TOKEN,
          fmt : data.format || 'json'
        }
        this.query = data.symbol + ".AU?";
        this.query += this.encodeQueryData(params);
        return this;
  }

  this.fetch = function(){
      var $url = this.BASE_URL + this.query;
      var deferred = $q.defer();
        $http({
          url: $url,
          method: 'GET',
        }).then(function(response) {
          deferred.resolve(response.data);
        }, function(response){
          deferred.reject(response);
        });
      return deferred.promise;
  }

  this.encodeQueryData = function(data) {
    let ret = [];
    for (let d in data)
      ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
    return ret.join('&');
  }

})

.service('StockSvc', function(EODSvc){

    this.name = '';
    this.symbol = '';
    this.data = {};
    this.$loaded = false;
  
    this.setName = function(name) {
        this.name = name;
    }

    this.setSymbol = function(symbol) {
        this.symbol = symbol;
    }

    this.fetch = function(){
        let stock = this;
        console.log(stock.name, stock.symbol)
        EODSvc.buildQuery({
          symbol : this.symbol
        }).fetch().then(function(data){
            stock.data = data;
            console.log(data,"datum")
            stock.$loaded = true;
        }).catch(function(error){
            console.log(error,"error");
        })
    }
})

.factory("Auth", function($firebaseAuth) {
    return $firebaseAuth();
})

.factory("FirebaseDatabase", function(){
    return firebase.database();
})

.factory("Ref", function(FirebaseDatabase) {
    return FirebaseDatabase.ref();
})

.factory("FirebaseStorage", function(){
    return firebase.storage();
})

.factory("FirebaseStorageRef", function(FirebaseStorage){
    return FirebaseStorage.ref()
})

.factory('Utils', function($q) {
    return {
        isImage: function(src) {
        
            var deferred = $q.defer();
        
            var image = new Image();
            image.onerror = function() {
                deferred.resolve(false);
            };
            image.onload = function() {
                deferred.resolve(true);
            };
            image.src = src;
        
            return deferred.promise;
        }
    };
})

.service('userList', function(FirebaseDatabase, $firebaseArray){
     let users = FirebaseDatabase.ref("userData");
     return $firebaseArray(users);
})