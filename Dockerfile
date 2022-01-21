ARG FROM_IMAGE=364215618558.dkr.ecr.eu-west-1.amazonaws.com/stratus-ecr-core-php:8.0
FROM $FROM_IMAGE

COPY filebeat.yml /etc/filebeat/filebeat.yml
RUN chmod 644 /etc/filebeat/filebeat.yml

# Let's work out why php-fpm isn't under supervisord
RUN yum install -y htop

# Modify your supervisor settings
COPY supervisor.ini /etc/supervisord.d/supervisor.ini

# NGINX
COPY default.conf /etc/nginx/sites-enabled/default.conf

# Run the command on container startup
CMD ["start-container"]

# Nov 25, 2020 at 11:12:00 AM
COPY . /app

RUN chown -R nginx /app/storage
RUN chown -R nginx /app/bootstrap
RUN touch app/storage/logs/laravel.log
RUN touch app/storage/logs/laravel.json
