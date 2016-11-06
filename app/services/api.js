(function() {
    'use strict';

    angular.module('ApiModule', ['CRMHTTPModule', 'ui.router', 'ErrorHandler', 'Validation'])
        .service('ApiService', ['CRMHTTPService', '$state', 'errorHandlerService', 'CheckSum',
            function(CRMHTTPService, $state, errorHandlerService, CheckSum) {

                var _setEnvironment = function(env) {

                    env.content = env.content || {};
                    env.content.data = env.content.data || {};
                    env.content.data.colleagues = env.content.data.colleagues || '';
                    try {
                        localStorage["colleagues"] = JSON.stringify(env.content.data.colleagues);
                        return;
                    } catch (e) {
                        throw new Error(e);
                    }
                    return;
                }

                this.processCustomer = function(state, entity) {
                    return $state.go(state, {
                        appl_id: (entity.id || "")
                    });
                }

                this.init = function(page, query) {
                    var self = this;

                    return new Promise(function(resolve, reject) {
                        return CRMHTTPService.getData('/' + page + '_init', {
                                appl_id: (query || "")
                            })
                            .then(function(res) {
                                return resolve(res.content);
                            }, function(err) {
                                return reject(err);
                            });
                    });
                }

                this.authenticate = function(params) {
                    var self = this;

                    return new Promise(function(resolve, reject) {

                        return CRMHTTPService.postData('/authenticate', params)
                            .then(function(res) {

                                return CRMHTTPService.setToken(res)
                                    .then(function() {
                                        //.getEnvironment() gets the environment object
                                        //and sets it locally
                                        return self.getEnvironment()
                                            .then(function(env) {
                                                _setEnvironment(env);
                                                return resolve();
                                            });
                                    }, function(err) {
                                        return reject(err);
                                    })

                            }).error(function(err) {
                                err = err || new Error("Unknown Error, server may be unreachable");
                                return reject(err);
                            });

                    })
                }

                this.getEnvironment = function() {
                    return new Promise(function(resolve, reject) {
                        return CRMHTTPService.getEnvironment()
                            .then(function(env) {
                                return resolve(env);
                            }, function(err) {
                                return reject(err);
                            });
                    });
                }

                this.getPerformanceData = function() {
                    
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //January is 0!
                    var yyyy = today.getFullYear();
                    if(dd<10){
                        dd='0'+dd
                    } 
                    if(mm<10){
                        mm='0'+mm
                    } 
                    var today = yyyy+'-'+mm+'-'+dd;
                    console.log(today); 
                    return new Promise(function(resolve, reject) {
                        return CRMHTTPService.getData('/pulse_performance')
                            .then(function(res){
                                console.log(res);
                                return resolve(res);
                            }, function(err){
                                return reject (err);
                            });
                    })
                }

                //this is not a submission, but I already have too many fucking services as is
                this.getCustomerApplication = function(customer_id) {
                    return new Promise(function(resolve, reject) {

                        return CRMHTTPService.getData('application', {
                                unique_customer_id: customer_id
                            })
                            .then(function(_application) {
                                return resolve(_application);
                            }, function(err) {
                                return reject(err);
                            });
                    });
                }

                this.postCustomerApplication = function(_identifiers, _changes) {

                    return new Promise(function(resolve, reject) {

                        return CRMHTTPService.postData('application', {
                                identifiers: _identifiers,
                                changes: _changes
                            })
                            .then(function(_application) {
                                console.log(_application);
                                return resolve(_application);
                            }, function(err) {
                                return reject(err);
                            });

                    });

                }

                this.mark_action = function(_action_id) {
                    return new Promise(function(resolve, reject){

                        return CRMHTTPService.postData('mark_action', {
                            action_id: _action_id.action_id,
                            state: 'Done'
                        })
                        .then(function(checkStock){
                            return resolve(checkStock);
                        }, function(err){
                            return reject(err);
                        })
                    });
                }

                //get lists of customers by status type
                //even if there is only one customer we return list
                this.getCustomerApplications = function(status, query, _search_Country) {

                    return new Promise(function(resolve, reject) {
                        return CRMHTTPService.getData(status, {
                            search: query,
                            byshop: _search_Country
                        }).then(function(_applications) {

                            _applications.content = _applications.content || {};
                            _applications.content.data = _applications.content.data || {};

                            return resolve(_applications.content.data);
                        }, function(err) {
                            return reject(err);
                        })
                    })
                }

                this.getCustomerList = function(query, status, _by_shop, _search_Country) {
                    var self = this;
                    return new Promise(function(resolve, reject) {

                        if (_by_shop) {
                            _search_Country = '1';
                        } else { 
                            _search_Country = '0';
                        }

                        return self.getCustomerApplications(status, query, _search_Country)
                            .then(function(_applications) {
                                
                                try {
                                    _applications = _applications || [];

                                    if (!_applications.length) {
                                        _applications = [];
                                    }
                                } catch (e) {
                                    return reject(e);
                                }

                                return resolve(_applications);
                            }, function(err) {
                                return reject(err);
                            })
                    })

                }

                //we should specify query type (name, action name, id, phone etc)
                this.query = function(query, data, filter_key) {

                    //wrap sync as async so to have handy error display
                    return new Promise(function(resolve, reject) {

                        //filter_key indexes a property on each element in the data array
                        //we can possibly use this to specifiy filters on the HTML

                        //we query customers in memory
                        if (parseInt(query)) {

                            if (query.toString().length > 5) {
                                //we will look for phone
                                var _ret = data.filter(function(ele, ele_idx) {
                                    if (ele.phone.toString().indexOf(query.toString()) !== -1) {
                                        return ele;
                                    }
                                });
                            } else {
                                //we will look for customer id
                                var _ret = data.filter(function(ele, ele_idx){
                                    if (ele.customer_id.toString().indexOf(query.toString()) !== -1) {
                                        return ele;
                                    }
                                });
                            }

                            return resolve(_ret);
                        } else {

                            try {

                                var _ret = data.filter(function(ele, ele_idx) {
                                    ele.name = ele.name || '';

                                    if (ele[filter_key].toString().toUpperCase().indexOf(query.toString().toUpperCase()) !== -1) {
                                        return ele;
                                    }
                                });

                                return resolve(_ret);
                            } catch (e) {
                                return reject(e);
                            }
                        }
                    })
                }


                var _dateTransform = function(dateString) {
                    //for Jack     
                    //NOTE: If we are submitting dates using the datepicker
                    
                    var _returnedDateString;
                    try {
                        _returnedDateString = (new Date(dateString).toISOString()).toUpperCase();

                    } catch (e) {
                        throw e;
                    }

                    return _returnedDateString;

                }

                this.submitForm = function(form, form_params) {
                    document.getElementById('loading').style.display = 'block';            

                    return new Promise(function(resolve, reject) {

                        try {

                            //Shit hack, we should fix the logic for ngOptions
                            //instead of doing this
                            Object.keys(form_params).forEach(function(_form_param) {
                                if (typeof form_params[_form_param] == "object") {

                                    if (form_params[_form_param].value) {
                                        form_params[_form_param] = form_params[_form_param].value;
                                    }
                                }

                                //Before angular.copy()
                                if (_form_param.indexOf('date') !== -1) {
                                    if (_form_param !== 'date_picker')
                                        form_params[_form_param] = _dateTransform(form_params[_form_param]);
                                    else if (_form_param === 'date_picker') {
                                        delete form_params[_form_param];
                                    }
                                }
                            });

                            if (form_params.successful == true) {

                                Object.keys(form_params).forEach(function(_form_param) {
                                    if (_form_param.indexOf('reason_for_failed_') !== -1) {
                                        delete form_params[_form_param]
                                    }
                                });
                            } else {

                                Object.keys(form_params).forEach(function(_form_param) {
                                    if (_form_param.indexOf('serial_number') !== -1) {
                                        //don't submit serial number for failed repossessions and seizures
                                        //because we can't validate them
                                        delete form_params[_form_param];
                                    }
                                });
                            }

                            if (form_params.serial_number) {
                                //pass to checksum
                                if (CheckSum.crc_check(String(form_params.serial_number))) {
                                    //continue,
                                } else {
                                    document.getElementById('loading').style.display = 'none';
                                    return reject("Serial number failed validation: " + form_params.serial_number);
                                }
                            }
 
                            Object.keys(form_params).forEach(function(_form_param) {

                                if (_form_param.indexOf('serial_number') !== -1 || _form_param.indexOf('products') !== -1) {
                                    //do nothing
                                } else if (_form_param.indexOf('appl_id') !== -1) {
                                    form_params[_form_param] = parseInt(form_params[_form_param])
                                } else {
                                    if (typeof form_params[_form_param] !== "boolean")
                                        // console.log(form_params[_form_param]);
                                        // form_params[_form_param] = form_params[_form_param];
                                        form_params[_form_param] = form_params[_form_param].toString();
                                }

                            });

                        } catch (e) {
                            document.getElementById('loading').style.display = 'none';
                            return reject(e);
                        }


                        return CRMHTTPService.postData(form, form_params)
                            .then(function(res) {
                                $state.go('index');
                                return resolve(res);
                            }, function(err) {
                                document.getElementById('loading').style.display = 'none';
                                return reject(err);
                            })
                    })

                }

            }
        ])
})();