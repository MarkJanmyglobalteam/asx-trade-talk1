asxTradeTalkApp
.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });
 
                event.preventDefault();
            }
        });
    };
})

.directive("fileRead", function (toastr) {
    return {
        scope: {
            fileRead: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    //console.log(loadEvent, "loadEvent")
                    scope.$apply(function () {
                        scope.fileRead.data = changeEvent.target.files[0];
                        scope.fileRead.src = loadEvent.target.result;
                        scope.fileRead.isLoaded = true;
                        scope.fileRead.fileType = checkFileType(changeEvent.target.files[0].type);                        
                    });
                }

                if(changeEvent.target.files.length > 0){
                  let file = changeEvent.target.files[0];
                  let fileType = file.type;
                  let fileSize = file.size / 1024 / 1024;
                  if(fileType.indexOf("image") === -1){
                    toastr.error('Invalid File Type','Error');
                    return;
                  }else if(fileSize > 2){
                    toastr.error('Max file size is 2MB','Error');
                    return;  
                  }
                  reader.readAsDataURL(changeEvent.target.files[0]);
                }

                function checkFileType(mimeType){
                     if(mimeType.indexOf("image") > -1){
                        return "image";
                     }else if(mimeType.indexOf("video") > -1){
                        return "video";
                     }
                }
            });
        }
    }
})

.directive("autoResize", function ($timeout) {
    return {
        restrict: 'A',
              link: function (scope, element, attributes) {
                  
                  var startHeight = scope.$eval(attributes.startHeight);
                  element.css({ 'height': 'auto', 'overflow-y': 'hidden','overflow-x': 'hidden'});
                  $timeout(function () {
                      element.css('height', startHeight + 'px');
                  }, 100);

                  element.on('input', function () {
                      
                      var height = startHeight;
                      if(startHeight < element[0].scrollHeight){
                            height = element[0].scrollHeight;
                      }
                      element.css({ 'height': 'auto', 'overflow-y': 'hidden','overflow-x': 'hidden'});
                      element.css('height', height + 'px');
                     

                  });
        }
    }
})

.directive("atWho", function($timeout, userList, $compile) {
  return {
    restrict: "A",
    require: "ngModel",
    link: function(scope, element, attrs, ngModel) {
   
    var emojis = $.map([
        "smile", "iphone", "girl", "smiley", "heart", "kiss", "copyright", "coffee",
        "a", "ab", "airplane", "alien", "ambulance", "angel", "anger", "angry",
        "arrow_forward", "arrow_left", "arrow_lower_left", "arrow_lower_right",
        "arrow_right", "arrow_up", "arrow_upper_left", "arrow_upper_right",
        "art", "astonished", "atm", "b", "baby", "baby_chick", "baby_symbol",
        "balloon", "bamboo", "bank", "barber", "baseball", "basketball", "bath",
        "bear", "beer", "beers", "beginner", "bell", "bento", "bike", "bikini",
        "bird", "birthday", "black_square", "blue_car", "blue_heart", "blush",
        "boar", "boat", "bomb", "book", "boot", "bouquet", "bow", "bowtie",
        "boy", "bread", "briefcase", "broken_heart", "bug", "bulb",
        "person_with_blond_hair", "phone", "pig", "pill", "pisces", "plus1",
        "point_down", "point_left", "point_right", "point_up", "point_up_2",
        "police_car", "poop", "post_office", "postbox", "pray", "princess",
        "punch", "purple_heart", "question", "rabbit", "racehorse", "radio",
        "up", "us", "v", "vhs", "vibration_mode", "virgo", "vs", "walking",
        "warning", "watermelon", "wave", "wc", "wedding", "whale", "wheelchair",
        "white_square", "wind_chime", "wink", "wink2", "wolf", "woman",
        "womans_hat", "womens", "x", "yellow_heart", "zap", "zzz", "+1",
        "-1"
    ], function(value, i) {
        return {
            key: value, 
            name:value
        };
    });

    userList.$loaded().then(function(){

      var userData = scope.$eval(attrs.userData);
      var symbolData = scope.$eval(attrs.symbolData);    
      
      var SymbolSettings = {
        at: "$",
        data: symbolData,
        displayTpl: "<li><strong>${symbol}</strong> ${name}</li>",
        insertTpl : "<strong class='text' ng-click='symbolClick(\"${symbol}\")'>${symbol}</strong>",
        highlightFirst: true,
        searchKey: "symbol",
        startWithSpace: true,
        spaceSelectsMatch: true,
        matcher: matcherFnc,
      };


      var EmojiSettings = {
          at: ":",
          data: emojis,
          displayTpl: "<li>${name} <img src='https://assets-cdn.github.com/images/icons/emoji/${key}.png'  height='20' width='20' /></li>",
          insertTpl: "<img src='https://assets-cdn.github.com/images/icons/emoji/${name}.png'  height='20' width='20' />",
          delay: 400,
          startWithSpace: true,
          spaceSelectsMatch: true,
          matcher: matcherFnc,
      };
     

      var UserSettings = {
          at: "@",
          data: userData,
          displayTpl: "<li> <img src='${photo}'  height='20' width='20' style='border-radius:50%; border: 2px solid #337ab7' /> ${fullname} </li>",
          insertTpl : "<strong class='text' ng-click='mentionClick(\"${uid}\")'>${fullname}</strong>",
          highlightFirst: true,
          searchKey: "fullname",
          startWithSpace: true,
          spaceSelectsMatch: true,
          matcher: matcherFnc,
      };

      // var HashSettings = {
      //     at: "#",
      //     startWithSpace: true,
      //     callbacks: {
      //     afterMatchFailed: function (at, el) {
      //       // 32 is spacebar
      //       if (at == '#') {
                
      //           var $li = $('<li></li>').data('item-data', {
      //               'atwho-at': at,
      //               'atwho_order': 0,
      //               'name': el.text().trim().slice(1)
      //           });
               
      //           this.insert('<span>'+ el.text().trim() +'</span>', $li);
                
      //           return false;
      //       }
      //     }
      //     }
      // }

       var HashSettings = {
          at: "www.",
          startWithSpace: true,
          callbacks: {
          afterMatchFailed: function (at, el) {
              console.log(at,"at")
          }
          }
      }


    
      element.atwho(EmojiSettings).atwho(UserSettings).atwho(SymbolSettings).atwho(HashSettings);
    
    })

    var matcherFnc = function(flag, subtext, should_start_with_space) {
      var match, regexp;

      flag = flag.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");

      if (should_start_with_space) {
        flag = '(?:^|\\s)' + flag;
      }

      regexp = new RegExp(flag + '([A-Za-z0-9_\\s\+\-\]*)$|' + flag + '([^\\x00-\\xff]*)$', 'gi');
      match = regexp.exec(subtext.replace(/\s/g, " "));
     
      if (match) {
       return match[2] || match[1];
      } else {
        return null;
      }
    };

    //var maxLength = scope.$eval(attrs.maxLength);

    element.on("keydown keyup change", function(event) {
       
       // var allowedKey = [8, 35, 36, 37, 38, 39, 40, 46];
       // if($(this).text().trim().length-1 <= maxLength){
       //     
       //      console.log($(this).text().trim().length)
       // }else if($.inArray(event.which, allowedKey) === -1){
       //      console.log("preventDefault")
       //      event.preventDefault();
       // }
        // if (event.which == 13 && event.shiftKey == false) {
        //   //Prevent insertion of a return
        //   //You could do other things here, for example
        //   //focus on the next field
        //   return false;
        // }
       
       scope.$apply(read($(this).html()));

    });  

    element.on('change', function () {
        $(this).find('[data-atwho-at-query="#undefined"]')
               .removeAttr("data-atwho-at-query")
               .addClass("hashtag");   
    });

    function read(html) {
       
       if(html === "<br>" || html === "&nbsp;"){
           html =  html.replace('<br>','').replace("&nbsp;","");
       }

       // let autolinker = new Autolinker();
       // var myLinkedHtml = autolinker.link(html);
       // console.log(myLinkedHtml,"myLinkedHtml")
       
       ngModel.$setViewValue(html.replace(/@&nbsp;/g,'')
                                  .replace(/\$&nbsp;/g,'')
                                  .replace(/:&nbsp;/g,'')
                                  .replace(/&nbsp;/g,' ')
                                  .trim());

    }

    ngModel.$render = function() {
        element.html(ngModel.$viewValue || "");
    };

    }
  };
})

.directive('bindHtmlCompile', function ($compile) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                  scope.$watch(
                    function(scope) {
                        return scope.$eval(attrs.bindHtmlCompile);
                    },
                    function(value) {
                        element.html(value);
                        try{
                          $compile(element.contents())(scope);
                        }catch(e){

                       }
                    }
                );
            }
        };
})

.directive('longPress', function ($timeout) {
  return {
    link: function(scope, element, attrs, ctrl) {
      var timer = null
      element.css({'background' : 'transparent'});
      element.bind('mousedown', function (e) {
        e.preventDefault();
        timer = $timeout(function(){
          console.log('long press')
          scope.$apply(function (){
             scope.$eval(attrs.longPress);
             element.css({'background' : '#dddddd38'})
             e.preventDefault();
          });
         
        }, 1000)
      })
      element.bind('mouseup', function (e) {
         $timeout.cancel(timer);
      })
    }

  }
})

.directive('hashtagify', function($timeout, $compile) {
        return {
            restrict: 'A',
            scope: {
                uClick: '&userClick',
                tClick: '&termClick'
            },
            link: function(scope, element, attrs) {
                $timeout(function() {
                    var html = element.html();

                    if (html === '') {
                        return false;
                    }

                    if (attrs.userClick) {
                        var mentionlistarr = html.match(/@\S+/g);
                        console.log(mentionlistarr,"mentionlistarr")
                        html = html.replace(/(|\s)*@(\w+)/g, '$1<a ng-click="uClick({$event: $event})" class="hashtag">@$2</a>'); 
                    }
                    
                    if (attrs.termClick) {
                        var hashlistarr = html.match(/#\S+/g);
                        console.log(hashlistarr,"hashlistarr")
                        html = html.replace(/(^|\s)*#(\w+)/g, '$1<a ng-click="tClick({$event: $event})" class="hashtag">#$2</a>');
                    }

                    element.html(html);
                    
                    $compile(element.contents())(scope);
                }, 0);
            }
        };
})
