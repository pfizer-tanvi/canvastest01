#!/usr/bin/env bash

source /app/.env

CMD=

for i in "$@"
do
    CMD="$CMD '$i'"
done

# Only logs to Kibana from staging or production. Also, explicitly setting LOG_KIBANA to true will
# force logging to Kibana locally.

if [ "$APP_ENV" == "staging" ] || [ "$APP_ENV" == "production" ] ; then
    LOG_KIBANA="true"
fi

if [[ "$LOG_KIBANA" == "true" ]] ; then
    echo "Logging to Kibana..."
    /etc/init.d/filebeat start
fi

echo $CMD
eval $CMD || true

if [[ "$LOG_KIBANA" == "true" ]] ; then
    # Sleeping so filebeat has enough time to upload last log entries.
    cat /app/storage/logs/laravel.log
    sleep 60

    echo "Stopping filebeat..."
    /etc/init.d/filebeat stop
fi