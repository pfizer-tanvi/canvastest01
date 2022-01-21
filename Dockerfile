ARG FROM_IMAGE=364215618558.dkr.ecr.eu-west-1.amazonaws.com/cat-core-docker:php_74b_min_20211117
FROM $FROM_IMAGE

ARG APP_NAME="app-name"
ARG APP_ENV="app-env"
ARG NEW_RELIC_LICENSE_KEY="nr-key"
ARG PHP_AGENT_URL="agent-url"

RUN yum install tar -y
RUN \
    curl -L ${PHP_AGENT_URL} | tar -C /tmp -zx && \
    export NR_INSTALL_USE_CP_NOT_LN=1 && \
    export NR_INSTALL_SILENT=1 && \
    /tmp/newrelic-php5-*/newrelic-install install && \
    rm -rf /tmp/newrelic-php5-* /tmp/nrinstall* && \
    sed -i \
        -e "s/\"REPLACE_WITH_REAL_KEY\"/\"${NEW_RELIC_LICENSE_KEY}\"/" \
        -e "s/newrelic.appname = \"PHP Application\"/newrelic.appname = \"${APP_NAME}-${APP_ENV}\"/" \
        -e 's/;newrelic.daemon.app_connect_timeout =.*/newrelic.daemon.app_connect_timeout=15s/' \
        -e 's/;newrelic.daemon.start_timeout =.*/newrelic.daemon.start_timeout=5s/' \
        /etc/php.d/newrelic.ini

COPY filebeat.yml /etc/filebeat/filebeat.yml
RUN chmod 644 /etc/filebeat/filebeat.yml

# Modify your supervisor settings
COPY supervisor.ini /etc/supervisord.d/supervisor.ini

# NGINX
COPY default.conf /etc/nginx/sites-enabled/default.conf

# Run the command on container startup
CMD ["start-container"]

# Nov 25, 2020 at 11:12:00 AM
COPY . /app

RUN chown -R nginx /app/bootstrap
RUN touch app/storage/logs/laravel.log
RUN touch app/storage/logs/laravel.json
