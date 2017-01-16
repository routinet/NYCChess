/* An AJAX wrapper library */

/* global namespace */
var cAJAX = cAJAX || {};

(function ($,window,undefined) {
    /* easy reference */
    var D = cAJAX;

    /* common variables */
    D.jqxhr = {};
    // default AJAX method
    D.ajax_method = "POST";
    // default AJAX URL
    D.ajax_url = '/ajaxhandler.php';

    /* TODO: For debugging only.  Remove, or set to false for production */
    D.debug_logger = true;

    /* a console logger */
    D.log = function() {
        if (D.debug_logger && arguments.length) {
            for (var i=0; i<arguments.length; i++) { console.log(arguments[i]); }
        };
    };

    /* Simple management of AJAX calls
     This handler utilizes the request cache cAJAX.jqxhr, and formats an
     AJAX request to include fields required by the server.  It also
     sets a method (default POST), a default dataType, and replaces the
     .complete callback with a custom handler.  Any current assignment
     of .complete is cached.  All AJAX parameters except .complete can
     be overridden by passing an options object.

     n = name of this AJAX call
     o = custom options to override defaults, see jQuery's .ajax() options
     cb = a callback to add to the end of the .complete chain
     */
    D.doAjax = function(n,o,cb) {
        n = n || 'default';
        o = o || { type:'POST' };
        var t = t || (o.type ? o.type : D.ajax_method),
            allcb = o.complete ? ($.isArray(o.complete) ? o.complete : [ o.complete ]) : []
            ;
        if (D.jqxhr[n]) {
            try {
                D.jqxhr.abort();
            } catch(e) { };
            D.jqxhr[n] = null;
        }
        ( ($.isArray(cb)) ? cb : [cb] ).forEach(function(v,k){
            if (v) { allcb.push(v); }
        });
        var oo = $.extend( { type:t, dataType:'json', url:D.ajax_url }, o, { complete:D.handlerDoAjax } );
        D.jqxhr[n] = $.ajax(oo);
        D.jqxhr[n].userHandler = allcb;
    };

    /* In case an AJAX call fails

     m = a message to use in the alert
     */
    D.failAlert = function(m) {
        alert(m);
    };

    /* handler for general AJAX
     A custom AJAX return handler.  When an AJAX call is executed
     through cAJAX.doAjax(), this handler is called before any other
     handlers in the .complete property.  After error checking the
     response, any other cached handlers (.complete, followed by
     the custom callback, see cAJAX.doAjax) are called in order.

     The function signature is as required for $.ajax.complete.
     */
    D.handlerDoAjax = function(r,s) {
        var $this = this;
        D.log('===AJAX response JSON', r.responseJSON);
        if ((!r.responseJSON) || r.responseJSON.result!='OK') {
            D.log('AJAX call failed! ('+s+")","result=",r.responseJSON.result,"\nmsg=",r.responseJSON.msg);
        }
        if (r.userHandler && r.userHandler.length) {
            r.userHandler.forEach(function(v,i){ if (v && typeof(v) == 'function') { v.call($this, r, s); } });
        } else {
            D.log('---AJAX call has no custom handlers');
        }
    };

    /* event handler for word hint return
     Currently unused by jquery-ui control
     Formats the AJAX response data into a single-element array, which is
     then stored in cAJAX.word_fragments.

     r = a jQuery response object
     */
    D.handlerWordFragment = function(r) {
        D.word_fragments = r.words.map(function(v,i){return v;});
    };

    /* submit word hint to AJAX handler
     Currently unused by jquery-ui control.
     Creates an AJAX request to retrieve suggestion words based on a word fragment.

     w = word fragment to send
     cb = a custom callback to add to the .complete chain
     */
    D.submitWordFragment = function(w, cb) {
        var o = { data:$.param({ requestType:'wordlist', fragment:w }), complete:cb || D.handlerWordFragment };
        D.doAjax('wordlist',o);
    }

})(jQuery,window);