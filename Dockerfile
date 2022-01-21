ARG FROM_IMAGE=364215618558.dkr.ecr.eu-west-1.amazonaws.com/cat-core-docker:php_74
FROM $FROM_IMAGE

COPY filebeat.yml /etc/filebeat/filebeat.yml
RUN chmod 644 /etc/filebeat/filebeat.yml

# Nov 25, 2020 at 11:12:00 AM
COPY . /app
RUN touch app/storage/logs/laravel.log
RUN touch app/storage/logs/laravel.json

ADD entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]