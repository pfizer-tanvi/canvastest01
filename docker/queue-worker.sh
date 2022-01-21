#!/bin/bash
echo "working default queue"
php /app/artisan queue:work sqs --once

LOG_KIBANA="true"
echo "Logging to Kibana..."
/etc/init.d/filebeat start
sleep 20
/etc/init.d/filebeat stop