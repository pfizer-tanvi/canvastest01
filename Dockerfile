ARG FROM_IMAGE=364215618558.dkr.ecr.eu-west-1.amazonaws.com/cat-core-docker:php_74
FROM $FROM_IMAGE

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
RUN touch app/storage/logs/laravel.log
RUN touch app/storage/logs/laravel.json
