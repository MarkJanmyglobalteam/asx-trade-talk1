asxTradeTalkApp.factory('forgotPasswordFtry', function($http, $q, Config){
  return {
  	sendPasswordResetLink: function(data) {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/authentication/password/forgot',
			method: 'POST',
			data: data
		}).then(function(response) {
			deferred.resolve(response.data);
		}, function(response){
			deferred.reject(response);
		});
		return deferred.promise;
	},
	resendLink: function(email) {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/authentication/forgot/password/resend-link/' + email,
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