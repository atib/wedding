(function() {
    'use strict';

    angular.module('Validation', [])
        .service('CheckSum', [

            function() {
                //The allowed character list used in serial number validation
                var CHAR_LIST = '0123456789ABCDEFGHIJKLMNPQRSTUVWXYZ'

                this.makeCRCTable = function() {
                    var c;
                    var crcTable = [];
                    for (var n = 0; n < 256; n++) {
                        c = n;
                        for (var k = 0; k < 8; k++) {
                            c = ((c & 1) ? (0xEDB88320 ^ (c >>> 1)) : (c >>> 1));
                        }
                        crcTable[n] = c;
                    }
                    return crcTable;
                }

                this.crc32 = function(str) {
                    var crcTable = window.crcTable || (window.crcTable = this.makeCRCTable());
                    var crc = 0 ^ (-1);

                    for (var i = 0; i < str.length; i++) {
                        crc = (crc >>> 8) ^ crcTable[(crc ^ str.charCodeAt(i)) & 0xFF];
                    }

                    return (crc ^ (-1)) >>> 0;
                };

                this.crc_encode = function(encode_str) {
                    encode_str = String(encode_str);
                    var crc = ((this.crc32(encode_str)) % (CHAR_LIST.length));
                    return encode_str + CHAR_LIST[crc];
                }

                this.crc_check = function(validate_str) {
                    validate_str = String(validate_str);

                    validate_str = validate_str.toUpperCase();

                    if (validate_str.charAt(0) !== 'C' || validate_str.charAt(1) !== 'U') {
                        if (validate_str.charAt(0) === 'B' && validate_str.charAt(1) === 'B') {
                            return true;
                        }
                        //If validateStr does not begin with CU or BB, it is not valid (or old)
                        //so don't bother with CheckSum
                        return false;
                    } 

                    return validate_str == this.crc_encode(validate_str.slice(0, validate_str.length-1));
                }
            }
        ])

})();