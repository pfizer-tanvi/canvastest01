FROM 364215618558.dkr.ecr.eu-west-1.amazonaws.com/cat-core-docker:amazon


COPY filebeat.yml /etc/filebeat/filebeat.yml
RUN chmod 644 /etc/filebeat/filebeat.yml

# Modify your supervisor settings
#COPY supervisor.ini /etc/supervisord.d/supervisor.ini

# Run the command on container startup
CMD ["start-container"]

## These are ignored till build
## https://course.shippingdocker.com/lessons/module-10/production-images
COPY packaged /app
RUN touch app/storage/logs/laravel.log
RUN touch app/storage/logs/laravel.json
