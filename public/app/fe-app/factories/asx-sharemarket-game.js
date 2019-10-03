asxTradeTalkApp.factory('asxShareMarketGameFtry', function($http, $q, Config){
  return {
  	get: function(list_type) {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/asx-sharemarket-game/forum/get/' + list_type,
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