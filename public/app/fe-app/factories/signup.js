asxTradeTalkApp.factory('signupFtry', function($http, $q, Config){
  return {
  	register: function(data) {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/authentication/register',
			method: 'POST',
			data: data
		}).then(function(response) {
			deferred.resolve(response.data);
		}, function(response){
			deferred.reject(response);
		});
		return deferred.promise;
	},
	existedEmail: function(email) {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/authentication/existed/' + email,
			method: 'GET'
		}).then(function(response) {
			deferred.resolve(response.data);
		}, function(response){
			deferred.reject(response);
		});
		return deferred.promise;
	},
	resendLink: function(user_id) {
		var deferred = $q.defer();
		$http({
			url: Config.BaseUrl + '/api/authentication/resend-link/' + user_id,
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