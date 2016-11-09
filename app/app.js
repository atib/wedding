var WeddingApp = angular.module('wedding', ['ui.bootstrap', 'ui.router']);

WeddingApp.config(['$stateProvider', '$urlRouterProvider',
	function($stateProvider, $urlRouterProvider) {

		$urlRouterProvider.otherwise("/");

		$stateProvider.state('index', {
			url: '/', 
			name: "index", 
			views: {
				'' : {
					templateUrl: 'app/views/main/main.html', 
					controller: function($stateParams, $state) {


					}
				}
			}
		})

		.state('details', {
			url: '/details',
			name: 'details',
			views: {
				'' : {
					templateUrl: 'app/views/main/details.html', 
					controller: function() {

					}
				}
			}
		})

		.state('contact', {
			url: '/contact',
			name: 'contact',
			views: {
				'' : {
					templateUrl: 'app/views/main/contact.html', 
					controller: function() {

					}
				}
			}
		})

		.state('playlist', {
			url: '/playlist',
			name: 'playlist',
			views: {
				'' : {
					templateUrl: 'app/views/main/playlist.html', 
					controller: function() {

					}
				}
			}
		})

		.state('photo', {
			url: '/photographs', 
			name: 'photo',
			views: {
				'': {
					templateUrl: 'app/views/main/photographs.html', 
					controller: function(){
						jQuery.instaShow();	
					}
				}
			}
		})

		.state('rsvp', {
			url: '/rsvp', 
			name: "rsvp", 
			views: {
				'': {
					templateUrl: 'app/views/main/rsvp.html',
					controller: function($scope) {
						
						
						
						$scope.rsvp_password = function() {
							if ($scope.password_rsvp == 'aw3som3n355') {
								return true;
							}
							else {
								false;
							}
						}
					
					}
				}
			}
		})

}]);