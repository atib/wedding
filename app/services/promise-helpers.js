//Promise helpers from Alex-CRM. Very useful to chain catch callbacks on failures on CRM
//Can be useful for support tickets to share

(function() {
    'use strict';

    String.prototype.htmlEncode = function() {
        return String(this)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    //point error to 'catch' method, cleaner
    Promise.prototype.error = Promise.prototype['catch'];

    Promise.prototype.success = function(path) {
        return this.then(function(arg) {
            return new Promise(function(resolve) {
                //pop up window with message passed to resolved promise, then resolve this
                bootbox.alert((arg || {}).message || "Success", resolve);
                // resolve;
                //path argument is for an optional redirect, will configure later
                if (typeof path === 'string') {
                    return (window.location.pathname = '/')
                }
            });
        });
    }

    Promise.prototype.fail = function(stackTrace, id, name) {
        //stack error trace on popup screen. Extremely useful for resolving strange ticket requests on current CRM
        return this['catch'](function(res) {
            var stack = null;

            if (res instanceof Error && stackTrace) {
                stack = res.stack;
            }



            if (typeof res !== 'string' && res) {
                if (res instanceof Error ) {
                    res = res.message;
                } else {
                    res = res.name || res.message || res.text || res.error;
                }
            }

            if (typeof res !== 'string') {
                try {
                    res = 'Unknown Error : ' + JSON.stringify(res);
                } catch (e) {

                }
            }
            // document.document.getElementById('loading').style.display = 'none';
            // var message = "<div class='error_modal_section'><span><i class='fa fa-warning'></i> " + (res || 'Unknown Error') + "</span></div>";
            
            var message = "<i class='fa fa-warning' style='color:red'></i>&nbsp;<b>ERROR:" + (res || 'Unknown Error') + "</b><br><br>Technical Details (for the IT Support, please include it if you ask for support):<br>" + "<pre style='font-size:8px'>\n" + "[+] Error: " + (res || "Unknown Error") + "\n" + (res.name ? "[+] Name: " + (res.name) : "\n") + "[+] Stack: " + (stack || new Error().stack.replace('Error', '')).htmlEncode() + "\n" + "\n" + "[+] URL: " + window.location.toString() + "\n" + "[+] Date: " + new Date().toISOString() + "\n" + "[+] User-Agent: " + navigator.userAgent + "\n" + "</pre>";

            if (stackTrace) {

                message = "<i class='fa fa-warning' style='color:red'></i>&nbsp;<b>ERROR:" + (res || 'Unknown Error') + "</b><br><br>Technical Details (for the IT Support, please include it if you ask for support):<br>" + "<pre style='font-size:8px'>\n" + "[+] Error: " + (res || "Unknown Error") + "\n" + (res.name ? "[+] Name: " + (res.name) : "\n") + "[+] Stack: " + (stack || new Error().stack.replace('Error', '')).htmlEncode() + "\n" + "\n" + "[+] URL: " + window.location.toString() + "\n" + "[+] Date: " + new Date().toISOString() + "\n" + "[+] User-Agent: " + navigator.userAgent + "\n" + "</pre>";
            }
 
            bootbox.alert({
                message: message,
                className: 'error-modal'
            })

        })
    }

    // Promise.prototype.fail = function() { 

    //     bootbox.alert('Sorry, there seems to be something wrong');
    // }

})();