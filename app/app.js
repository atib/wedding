var WeddingApp = angular.module('wedding', ['ui.bootstrap', 'ui.router']);

WeddingApp.config(['$stateProvider', '$urlRouterProvider',
	function($stateProvider, $urlRouterProvider) {

		$urlRouterProvider.otherwise("/");

		$stateProvider.state('index', {
			url: '/', 
			name: "index", 
			views: {
				'' : {
					templateUrl: 'app.html', 
					controller: function($stateParams, $state) {

					}
				}
			}
		})

}]);