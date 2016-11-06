(function() {
    'use strict';

    var _api;

    if (location.protocol !== 'http:')
        _api = location.protocol + "//" + location.hostname + "/api";
    else
        _api = 'https://testpulse1.bboxx.co.uk/api';

    angular.module('CRMHTTPModule', ['ui.router', 'ErrorHandler'])
        .constant('constants', {
            API: _api,
            PORT: "80"
        })
        
        .service('CRMHTTPService', ['$http', 'constants', '$state', 'errorHandlerService',
            function($http, constants, $state, errorHandlerService) {

                var _token = null,
                    _exp_date = null;

                var _getToken = function() {

                    try {
                        _token = localStorage["token"] || null;
                        _exp_date = localStorage["exp_date"] || null;
                    } catch (e) {
                        _token = null;
                        _exp_date = null;
                    }

                    return {
                        token: _token,
                        exp_date: _exp_date
                    }
                }

                this.setToken = function(res) {
                    //this also sets other infos
                    res.content = res.content || {};
                    res.content.data = res.content.data || {};
                    return new Promise(function(resolve, reject) {
                        try {
                            localStorage["token"] = res.content.data.token;
                            if (res.content.exp_date instanceof Date) {
                                localStorage["exp_date"] = res.content.data.exp_date.toISOString();
                            } else {
                                localStorage["exp_date"] = res.content.data.exp_date;
                            }

                            localStorage["company"] = res.content.data.company;
                            localStorage["email"] = res.content.data.email;

                            if (res.content.data.shops.length)
                                localStorage["shops"] = res.content.data.shops;
    
                            localStorage["name"] = res.content.data.name;
                            localStorage["last_login"] = res.content.data.last_login;
                            localStorage["groups"] = res.content.data.groups || [];
                            localStorage["main_role"] = res.content.data.main_role || '';
                            localStorage["org_name"] = res.content.data.ou_name || ''; 
                            localStorage["org_type"] = res.content.data.ou_type || ''; 
                            localStorage["technicians"] = JSON.stringify(res.content.data.technicians) || [];
                            localStorage["shopmanager_code"] = res.content.data.code; 
                            localStorage["shopmanager_id"] = res.content.data.id;

                            //console.warn(res)
                            return resolve();
                        } catch (e) {
                            console.error(e);
                            return reject(e);
                        }
                    });
                }

                this.getEnvironment = function() {

                    var self = this;
                    return new Promise(function(resolve, reject) {
                        return self.getData('get_env', null)
                            .then(function(env) {
                                return resolve(env);
                            }, function(err) {
                                return reject(err);
                            })
                    })

                }

                this.getData = function(endpoint, params) {

                    var self = this;

                    var env = _getToken();

                    if (!(params)) {
                        //ie: if we pass null
                        params = {};
                    }

                    if (endpoint.charAt(0) !== '/')
                        endpoint = '/' + endpoint;

                    var req = {
                        method: 'GET',
                        url: constants.API + endpoint,
                        params: params,
                        headers: {
                            "X-Auth-Token": env.token                        },
                        timeout: 310000
                    };

                    return new Promise(function(resolve, reject) {
                        //we will just use submit method
                        return self.submitToApi(req, env)
                            .then(function(data) {
                                return resolve(data);
                            }, function(err) {
                                return reject(err);
                            });
                    });
                }

                this.postData = function(endpoint, params) {

                    var self = this;

                    var env = _getToken();

                    if (!(params)) {
                        //ie: if we pass null
                        params = {};
                    }

                    if (endpoint.charAt(0) !== '/')
                        endpoint = '/' + endpoint;

                    var req = {
                        method: 'POST',
                        url: constants.API + endpoint,
                        data: params,
                        headers: {
                            "X-Auth-Token": env.token
                        },
                        timeout: 310000
                    }
                    return new Promise(function(resolve, reject) {
                        //we will just use submit method
                        return self.submitToApi(req, env)
                            .then(function(data) {
                                return resolve(data);
                            }, function(err) {
                                return reject(err);
                            });
                    });
                }



                this.submitToApi = function(req, env) {

                    return new Promise(function(resolve, reject) {

                        return _checkToken(req.url, env)
                            .then(function(res) {

                                if (localStorage["testing"]) {

                                    return _checkMock(req)
                                        .then(function(res) {
                                            return resolve(res)
                                        });
                                }

                                $http(req).success(function(res) {
                                    return errorHandlerService.checkHTTPError(res)
                                        .then(function(res) {
                                            return resolve(res);
                                        }, function(err) {
                                            return reject(err);
                                        })
                                }).error(function(err) {

                                    if (err === null) {
                                        err = new Error('The server may not be reachable');
                                    }
                                    return reject(err);
                                });
                            }, function(err) {

                                return reject(err || "Token expired");
                            })
                    })
                }

                //This is for dashboard
                this.checkToken = function() {
                    //lets just call _checkToken, endpoints don't matter
                    //this is shitty hack to just not allow people to open dashboard
                    //with authenticating
                    return _checkToken('/', _getToken());
                }

                //private method

                var _checkToken = function(url, env) {
                    var no_valid_token = {
                        msg: 'No Valid Token',
                        message: 'No valid token, please login again',
                        status: 401,
                        content: null
                    };

                    var token_expired = {
                        msg: 'Token Expired',
                        message: 'Token Expired, Please login again',
                        status: 401,
                        content: null
                    };

                    //we dont need to check token on authentication
                    if (url.indexOf('/authenticate') !== -1)
                        return Promise.resolve();

                    if (location.href.indexOf('login') !== -1) 
                        return Promise.resolve();

                    return new Promise(function(resolve, reject) {

                        if (!(env.token)) {
                            //if !env.token, then we should just return
                            //to login

                            return resolve($state.go('login'));
                        }

                        var now = new Date();
                        var today = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(),  now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds()); 

                        if (new Date(env.exp_date) <= new Date(today)) {

                            $state.go('logged_out', {
                                error: token_expired.message
                            });
                            return resolve();
                        } else {
                            return resolve();
                        }

                    })

                }

            }
        ])


})();