(function() {
    'use strict';

    angular.module('LoginModule', ['ErrorHandlerModule', 'HTTPModule', 'ApiModule', 'ngMessages', 'ui.router'])
        .controller('loginCtrl', ['$scope', '$sce', '$http', '$timeout', 
            '$q', 'errorHandlerService', 'constants', 'HTTPService', 'ApiService', '$state',
            function($scope, $sce, $http, $timeout, $q, errorHandlerService,
                constants, CRMHTTPService, ApiService, $state) {

                $scope.emailHTML = $sce.trustAsHtml('Enter your BBOXX email address, it should end in <b>@bboxx.co.uk </b>');

                $scope.hideMenu = true;

                var _routeUser = function(groups) {
                    //maybe we can change the pathname here with groups later
                    return location.href="/";
                }


                $scope.submitLogin = function() {

                    var _saved = document.getElementById("progressCallback").getAttribute("value");

                    var _loggingIn = function() {
                        document.getElementById('loading').style.display = 'block';
                        document.getElementById('progressCallback').setAttribute('value', 'Logging in...');
                        document.getElementById('progressCallback').style['pointer-events'] = 'none';
                    }

                    var _loggedIn = function() {
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('progressCallback').setAttribute('value', 'Login');
                        document.getElementById('progressCallback').style['pointer-events'] = "";
                    }

                    return new Promise(function(resolve, reject) {
                        _loggingIn();

                        return ApiService.authenticate({
                                username: $scope.login.email,
                                password: $scope.login.password
                            }).then(function() {
                                _loggedIn();
                                return resolve(_routeUser(localStorage["main_role"]));
                            }).error(function(err) {
                                _loggedIn();
                                err = err || new Error("Unknown Error, server may be unreachable");
                                return reject(err);
                            })

                    }).fail(false);
                }

                $scope.showPassword = function() { 
                    
                }


                var _passwordField = document.getElementById("password"); 
                var capsLockSpan = document.getElementById("passCapsLock");
                
                _passwordField.addEventListener('keypress', function(e){
                    
                    var stringPassword = String.fromCharCode(e.which);
                
                    if (stringPassword.toUpperCase() === stringPassword && stringPassword.toLowerCase() !== stringPassword && !e.shiftKey ) 
                    {
                        capsLockSpan.style.visibility = 'visible';
                    }   
                    else {
                        capsLockSpan.style.visibility = 'hidden';
                    }

                    
                });
            }
        ])
})();