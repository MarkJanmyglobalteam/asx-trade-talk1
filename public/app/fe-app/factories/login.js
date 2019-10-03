asxTradeTalkApp.factory('loginFtry', function($http, $q, Config){
  return {
  	getAuthenticateUser : function() {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/authentication/user/get',
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