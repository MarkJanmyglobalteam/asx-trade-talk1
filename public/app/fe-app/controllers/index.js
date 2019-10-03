'use strict';

asxTradeTalkApp.controller('indexCtrl', function($scope, $timeout, moment, indexFtry){
	
    $scope.init = function(){
        $scope.$index.$init();
    };

    $scope.$index = {
        $variable : {    
            imageList : [],
            rated_posts : [],
            latest_posts : [],
            slickConfigLoaded : false,
            isLoaded : true,
            slickConfig : {
              method: {},
              dots: true,
              infinite: true,
              verticalSwiping : true,
              autoplay : true,
              speed: 300,
              slidesToShow: 2,
              slidesToScroll: 2,
              vertical : true,
              responsive: [
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
              ]
            },
            labels : [ 10, 11, 12, 13, 14, 15, 16 ],
            volume : [ 1270, 3421, 1000, 2100, 4273, 3321, 3211 ],
            data : [ 6020, 6030, 6040, 6050 ],
            chartOptions : {
              scales : {
                  yAxes : [{
                     id : 'A',
                     type : 'linear',
                     position : 'left',
                     scaleLabel : {
                       display : true,
                       labelString : 'Price'
                     },
                     ticks : {
                        min : 0,
                        max : 100
                     },

                  }]
              },
              tooltips: {
              //mode: "label",
              callbacks: {
                  label: function(tooltipItem, data) {
                      var legend = new Array();
                      for(var i in data.datasets){
                          legend.push(
                              data.datasets[i].label + ": <br/>dsfsd" + parseFloat(data.datasets[i].data[tooltipItem.index])
                          );
                      }

                      return legend;
                  }
              },
              custom: function(tooltip) {
                if (!tooltip) return;
                // disable displaying the color box;
                tooltip.displayColors = false;
              },
              // callbacks: {
              //   // use label callback to return the desired label
              //   label: function(tooltipItem, data) {
              //     //console.log($scope.volume[tooltipItem.index], "volume")
              //     var dateNow = moment(new Date()).format('ddd, MMM. Do YYYY');
              //     var $layout =  dateNow + "\n" + tooltipItem.xLabel + "\n" + tooltipItem.yLabel;
              //     return $layout;
              //   },
              //   // remove title
              //   title: function(tooltipItem, data) {
              //     return;
              //   }
              // },
              mode: 'single',
             }, 
           },
           myJson : {
              gui: {
                contextMenu: {
                  button: {
                    visible: 0
                  }
                }
              },
              backgroundColor: "#434343",
              globals: {
                  shadow: false,
                  fontFamily: "Helvetica"
              },
              type: "area",

              legend: {
                  layout: "x4",
                  backgroundColor: "transparent",
                  borderColor: "transparent",
                  marker: {
                      borderRadius: "50px",
                      borderColor: "transparent"
                  },
                  item: {
                      fontColor: "white"
                  }

              },
              scaleX: {
                  maxItems: 8,
                  transform: {
                      type: 'date'
                  },
                  zooming: true,
                  values: [
                    1442905200000, 1442908800000, 
                    1442912400000, 1442916000000, 
                    1442919600000, 1442923200000, 
                    1442926800000, 1442930400000, 
                    1442934000000, 1442937600000, 
                    1442941200000, 1442944800000, 
                    1442948400000
                  ],
                  lineColor: "white",
                  lineWidth: "1px",
                  tick: {
                      lineColor: "white",
                      lineWidth: "1px"
                  },
                  item: {
                      fontColor: "white"
                  },
                  guide: {
                      visible: false
                  }
              },
              scaleY: {
                  lineColor: "white",
                  lineWidth: "1px",
                  tick: {
                      lineColor: "white",
                      lineWidth: "1px"
                  },
                  guide: {
                      lineStyle: "solid",
                      lineColor: "#626262"
                  },
                  item: {
                      fontColor: "white"
                  },
              },
              tooltip: {
                    text: "%v requests"
              },
              crosshairX: {
                  scaleLabel: {
                      backgroundColor: "#fff",
                      fontColor: "black"
                  },
                  plotLabel: {
                      backgroundColor: "#434343",
                      fontColor: "#FFF",
                      _text: "Number of hits : %v"
                  }
              },
              plot: {
                  lineWidth: "2px",
                  aspect: "spline",
                  marker: {
                      visible: false
                  }
              },
              series: [{
                  text: "All Sites",
                  values: [2596, 2626, 4480, 
                           6394, 7488, 14510, 
                           7012, 10389, 20281, 
                           25597, 23309, 22385, 
                           25097, 20813, 20510],
                  backgroundColor1: "#77d9f8",
                  backgroundColor2: "#272822",
                  lineColor: "#40beeb"
              }, {
                  text: "Site 1",
                  values: [479, 199, 583, 
                           1624, 2772, 7899, 
                           3467, 3227, 12885, 
                           17873, 14420, 12569, 
                           17721, 11569, 7362],
                  backgroundColor1: "#4AD8CC",
                  backgroundColor2: "#272822",
                  lineColor: "#4AD8CC"
              }, {
                  text: "Site 2",
                  values: [989, 1364, 2161, 
                           2644, 1754, 2015, 
                           818, 77, 1260, 
                           3912, 1671, 1836, 
                           2589, 1706, 1161],
                  backgroundColor1: "#1D8CD9",
                  backgroundColor2: "#1D8CD9",
                  lineColor: "#1D8CD9"
              }, {
                  text: "Site 3",
                  values: [408, 343, 410, 
                           840, 1614, 3274, 
                           2092, 914, 5709, 
                           6317, 6633, 6720, 
                           6504, 6821, 4565],
                  backgroundColor1: "#D8CD98",
                  backgroundColor2: "#272822",
                  lineColor: "#D8CD98"
              }]
            }
        },
        $init : function(){
             
             var self = this;
             self.$variable.isLoaded = true;
             indexFtry.get().then(function(data){
                self.$variable.slickConfigLoaded = true
                self.$variable.isLoaded = false;
                self.$variable.imageList = data.imagelist;
                self.$variable.rated_posts = data.rated_posts;
                self.$variable.latest_posts = data.latest_posts;
             });

               // Simulate async data update
              $timeout(function () {
                self.$variable.data = [
                  [28, 48, 40, 19, 86, 27, 90],
                ];
              }, 3000);
        },
        $onClick : function(points, evt){
            console.log(points, evt);
        },      
    };

    $scope.load = function(){
         $scope.$index.$variable.isLoaded = true;
         $scope.$index.$variable.rated_posts = [];
         $scope.$index.$variable.latest_posts = [];
         indexFtry.get().then(function(data){
                $scope.$index.$variable.isLoaded = false;
                $scope.$index.$variable.rated_posts = data.rated_posts;
                $scope.$index.$variable.latest_posts = data.latest_posts;
             });

    };

    return $scope.init();
	  
});