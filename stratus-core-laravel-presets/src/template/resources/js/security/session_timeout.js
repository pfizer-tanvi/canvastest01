(function(){
    'use strict';

    var defaults = {
        message: 'Your session is about to expire.',
        keepAliveUrl: '/keep-alive',
        keepAliveAjaxRequestType: 'POST',
        redirUrl: '/logout',
        logoutUrl: '/logout',
        warnAfter: 780000, // 13 minutes
        redirAfter: 900000, // 15 minutes
        appendTime: true // appends time stamp to keep alive url to prevent caching
    };

    if (window.location.pathname != '/login') {
        $.sessionTimeout(defaults);
    }
})();
