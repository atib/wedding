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
						
						$scope.options = 
						[
			        {
			          name: 'No Additional Guest',
			          value: '0'
			        }, 
			        {
			          name: '1 Guest',
			          value: '1'
			        }, 
			        {
			          name: '2 Guests',
			          value: '2'
			        }, 
			        {
			          name: '3 Guests',
			          value: '3'
			        }, 
			        {
			          name: '4 Guests',
			          value: '4'
			        }, 
			        {
			          name: '5 Guests',
			          value: '5'
			        }

				    ];

				    $scope.additonal_guests = $scope.options[0].value;
							
						$scope.rsvp_password = function() {
							if ($scope.password_rsvp == 'aw3som3n355') {
								$('#mainrsvpform').addClass('showfadein');
								document.getElementById('rsvp_password_field').style.display = 'none';
								return true;
							}
						}


					
					}
				}
			}
		})

}]);