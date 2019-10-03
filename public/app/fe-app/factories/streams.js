asxTradeTalkApp.factory('streamsFtry', function($http, $q, Config){
  return {
  	createPost: function(data) {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/streams/create',
			method: 'POST',
			data: data
		}).then(function(response) {
			deferred.resolve(response.data);
		}, function(response){
			deferred.reject(response);
		});

		return deferred.promise;
	},
	getPost: function() {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/streams/retrieve',
			method: 'GET',
		}).then(function(response) {
			deferred.resolve(response.data);
		}, function(response){
			deferred.reject(response);
		});

		return deferred.promise;
	},
 }
});