(function () {
	'use strict'; 

	angular
	.module('authenticationModule', ['ErrorHandlerModule', 'ApiModule', 'ui.router'])
	.service('loginService', ['$http', '$timeout', 'errorHandlerService','HTTPService', 'ApiService',
		function($timeout, errorHandlerService, HTTPService, ApiService){
			
			this.submit = function(username, password) {

				var loadingShow = function(){
					document.getElementById('loading').style.display = 'block';
				}

				var loadingHide = function(){
					document.getElementById('loading').style.display = 'none';
				}

				return new Promise(function(resolve, reject){
					loadingShow(); 
					
					return ApiService.authenticate({
						username: username, 
						password: password
					}).then(function(){
						loadingHide(); 
						console.log('logged in');
						return resolve(); 
					}).error(function(err){
						loadingHide(); 
						console.log('couldnt log in');
						err = err || new Error("Unknown Error, Server May be Unreachabled");
						return reject(err);
					})

				}).fail(false);

			}

		}	
	])
})