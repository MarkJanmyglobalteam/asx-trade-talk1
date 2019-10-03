asxTradeTalkApp.factory('announcementFtry', function($http, $q, Config){
  return {
  	getSymbols: function() {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/announcement/get/symbols',
			method: 'GET'
		}).then(function(response) {
			deferred.resolve(response.data);
		}, function(response){
			deferred.reject(response);
		});

		return deferred.promise;
	},
	getAnnouncements : function(){
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/announcement/get/announcements',
			method: 'GET'
		}).then(function(response) {
			deferred.resolve(response.data);
		}, function(response){
			deferred.reject(response);
		});

		return deferred.promise;
	},
 }
});