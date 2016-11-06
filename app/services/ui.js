//utility methods borrowed from Alex's CRM
//Just bootbox utility methods that can be called on promise resolves/rejects
(function(){
	'use strict';

	angular.module('ui-elements', [])
	.service('UIElements',
		['$location', '$timeout', '$rootScope',
		function($location, $timeout, $rootScope) {

			this.successPopup = function (cb) {

				if (typeof cb !== 'function') {
					cb = function() {
						//just blank function
					};
				};

				return bootbox.alert({
					message: 'SUCCESS',
					callback: function(){
						$timeout(function(){
							//force digest
							$rootScope.$apply();
						});
						//then do cb();
						cb();
					}
				});
			}

			this.areYouSurePopup = function(cb) {
				if (typeof cb !== 'function') {
					cb = function(){};
				}

				bootbox.dialog({
					message: 'Are you really sure?',
					title: 'Are you really sure?',
					buttons: {
						cancel: {
							label: 'CANCEL',
							className: 'btn-default'
						},
						yes: {
							label: 'YES',
							//classname click-once to prevent double submission. Big problem in Alex-CRM
							//Not as big an issue with a live CRM with back-end validation but still good to have
							className: 'btn-secondary click-once',
							callback: function(){
								document.getElementsByClassName('click-once')[0].style['pointer-events'] = 'none';
								cb();
							}
						}
					}
				});
			}
		}])
})();