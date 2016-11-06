(function() {
    'use strict';

    angular.module('ErrorHandler', [])
        .service('errorHandlerService', function() {

            //note: All of these things return promises because I like to keep my async interface's consistent
            //Also, the promise handler class we have propogates rejected promises to a class which pops up nice
            //error pop up windows which we need for training and for IT support
            //I try to use ECMA6 Promises where possible and not use angular's $q because it is shit, 
            //but promises are agnostic anyway so doesn't really matter

            this.checkHTTPError = function(res) {

                var self = this;

                return new Promise(function(resolve, reject) {
                    var status = null,
                        err_msg = "Something went wrong, Error Code: ";
                    var unknown_err_msg = "Unknown (Please Contact IT)";

                    if (!res) {
                        return reject(new Error("Server cannot be found or no valid response detected"));
                    }

                    if (!res.content && !res.request_status) {
                        return reject(new Error("Invalid data returned by server"));
                    }

                    res.content = res.content || {};
                    //res.content can be null, create object


                    //console.warn(res.request_msg);

                    if (res.request_status) {
                        if (res.request_status === null || res.request_status.toString().charAt(0) === '4' || res.request_status.toString().charAt(0) === '5') {
                            //no status, try to retrieve it from data object
                            //Nginx throws away CORS headers and Angular throws away HTTP error codes after this
                            //This happens when request failes, so we need to get a bit hacky
                            if (res.content.field_errors) {
                                self.checkFormSubmissionErrors(res)
                            }
                            if (res.request_msg.toString() == 'Invalid Credentials'){
                                res.request_msg = 'Incorrect username or password';
                                return reject(new Error(" " + res.request_msg + "<br/> Visit <a href='https://user.bboxx.co.uk' target='_blank'>user.bboxx.co.uk</a>"))
                            }
                            else {
                                return reject(new Error("Error: "+ res.request_status + " " + res.request_msg));
                            }
                        } else {
                            //we should not have field_errors if request status
                            //is OK, this should not execute really
                            if (res.content.field_errors)
                                self.checkFormSubmissionErrors(res);
                            }
                    }

                    return resolve(res);
                });
            }

            this.checkFormSubmissionErrors = function(res) {

                //return new Promise(function(resolve, reject) {

                if (!res.content) {
                    return new Error("Invalid data returned by server");
                }


                if (res.content) {

                    //these are the parameters which failed validation checks
                    var params = res.content.field_errors;
                    var elements = document.getElementsByClassName('validation-failure');
                    var class_list = 'form-control';
                    Object.keys(elements).forEach(function(ele) {

                        if (typeof elements[ele] != 'undefined') {
                            $(elements[ele]).removeClass('validation-failure');
                        }
                    });

                    //Until I can get this working...
                    var messages = document.getElementsByClassName('validation-failure-message');
                    $('.validation-failure-message').remove();

                    Object.keys(params).forEach(function(_param_field_name) {

                        try {

                            if (document.getElementById(_param_field_name)) {

                                if (document.getElementById(_param_field_name).className.indexOf('validation-failure') == -1) {
                                    document.getElementById(_param_field_name).className += (' ' + 'validation-failure');

                                    var validation_message_element = document.createElement("div");

                                    validation_message_element.innerHTML = validation_message_element.innerHTML + params[_param_field_name];

                                    $(validation_message_element).addClass(' validation-failure-message');

                                    validation_message_element.id = 'validation_'+_param_field_name;

                                    document.getElementById(_param_field_name).insertAdjacentElement('afterend', validation_message_element);

                                }
                            }

                        } catch (e) {

                            return res;
                        }

                    });

                    return new Error(res.message || res.msg || "Form failed validation checks, please check the marked fields");

                } else {
                    return res;
                }

                //})
            }

        })
})();