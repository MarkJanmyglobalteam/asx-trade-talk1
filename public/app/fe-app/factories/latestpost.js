asxTradeTalkApp.factory('latestpostFtry', function($http, $q, Config){
  return {
  	get: function() {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/latest-post/get',
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