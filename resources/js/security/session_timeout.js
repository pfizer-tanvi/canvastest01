(function () {
  'use strict';

  const timeoutInMinutes = parseInt(window.Laravel.sessionLifetimeInMinutes);

  /**
   * If time is less then 10 minutes, warn after 80% of the time. Else warn before 5 minutes of ending.
   */
  let warnAfter = timeoutInMinutes * 0.8;
  if (timeoutInMinutes > 10) {
    warnAfter = timeoutInMinutes - 5;
  }

  const defaults = {
    message: 'Your session is about to expire.',
    keepAliveUrl: '/keep-alive',
    keepAliveAjaxRequestType: 'POST',
    redirUrl: '/logout',
    logoutUrl: '/logout',
    warnAfter: warnAfter * 60000, /*Convert to milliseconds*/
    redirAfter: timeoutInMinutes * 60000, /*Convert to milliseconds*/
    appendTime: true // appends time stamp to keep alive url to prevent caching
  };

  window.SessionTimeoutManager = {
    sessionTimeout: null,
    defaults: defaults,
    refresh() {
      this.sessionTimeout.refresh();
    },
    init() {
      if (window.location.pathname !== '/auth/login' && window.location.pathname !== '/login' && !window.location.pathname.startsWith('/password')) {
        this.sessionTimeout = $.sessionTimeout(this.defaults);
        this.sessionTimeout.refresh();
      }
      this.registerHttpInterceptor();
    },
    registerHttpInterceptor() {
      axios.interceptors.response.use((response) => {
        this.refresh();
        return response;
      }, (error) => {
        this.refresh();
        return Promise.reject(error);
      });
    },
  };
  window.SessionTimeoutManager.init();

})();
