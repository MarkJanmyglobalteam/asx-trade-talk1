asxTradeTalkApp.factory('resetPasswordFtry', function($http, $q, Config){
  return {
  	 resetPassword : function(data) {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/authentication/password/reset',
			method: 'POST',
			data: data
		}).then(function(response) {
			deferred.resolve(response.data);
		}, function(response){
			deferred.reject(response);
		});
		return deferred.promise;
	}
 }
});