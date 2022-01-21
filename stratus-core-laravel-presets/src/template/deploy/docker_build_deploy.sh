#!/usr/bin/env bash

# Bail out on first error
set -e

## Get the directory of the build script
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

## Get the current git commit sha
HASH=$(git rev-parse HEAD)

echo "Going to sync up file from root to packaged area"
echo "This assumes yarn run production/dev was run before hand"
cd $DIR/../
rsync -ralq --delete --progress --ignore-errors --exclude=node_modules/laravel-elixir --exclude=.gitignore --exclude=.vscode --exclude=.idea --exclude=deploy --exclude=.git --exclude=.env . $DIR/app/packaged

echo "Setting up filebeat staging make sure file exists"
cp $DIR/app/filebeat_staging.yml $DIR/app/filebeat.yml

echo "Getting ENV file from Secrets cat/${APP_NAME}-${STACK_ENV_TAG}/core"
aws secretsmanager get-secret-value --secret-id "cat/${APP_NAME}-${STACK_ENV_TAG}/core" --query SecretString --output text --region eu-west-1 > $DIR/app/packaged/.env
echo "Getting Core Env Settings"
printf "\n# ENV CORE SETTINGS\n" >> $DIR/app/packaged/.env
aws secretsmanager get-secret-value --secret-id "cat/env/core" --query SecretString --output text --region eu-west-1 >> $DIR/app/packaged/.env
printf "\n# END ENV CORE SETTINGS\n" >> $DIR/app/packaged/.env
echo "Getting your env additions"
printf "\n# ENV ADDITIONS\n" >> $DIR/app/packaged/.env
aws secretsmanager get-secret-value --secret-id "cat/${APP_NAME}-${STACK_ENV_TAG}/additions" --query SecretString --output text --region eu-west-1 >> $DIR/app/packaged/.env
printf "\n# END ENV ADDITIONS\n" >> $DIR/app/packaged/.env

cd $DIR/app/packaged

##we only want non-dev vendors
composer config -g github-oauth.github.com $GITHUB_TOKEN && composer install --no-dev

eval $(aws ecr get-login --no-include-email --region eu-west-1)
cd $DIR/app
echo "Tagging images $APP_NAME"
docker build --pull -t $APP_NAME .
docker tag $APP_NAME:latest 364215618558.dkr.ecr.eu-west-1.amazonaws.com/$APP_NAME:latest
echo "Pushing up image $APP_NAME:latest"
docker push 364215618558.dkr.ecr.eu-west-1.amazonaws.com/$APP_NAME:latest
##docker push 364215618558.dkr.ecr.eu-west-1.amazonaws.com/cat-teamdocs:$HASH
##git reset HEAD -- $DIR/app/packaged

## Now Run again for UAT
## if uat set???
if [[ "$BUILD_UAT" ]]; then
    echo "Setting up filebeat uat make sure file exists"
    cp $DIR/app/filebeat_uat.yml $DIR/app/filebeat.yml

    echo "Running UAT build"
    echo "Getting ENV file from Secrets cat/${APP_NAME}-uat/core"
    aws secretsmanager get-secret-value --secret-id "cat/${APP_NAME}-uat/core" --query SecretString --output text --region eu-west-1 > $DIR/app/packaged/.env
    echo "Getting Core Env Settings"
    printf "\n# ENV CORE SETTINGS\n" >> $DIR/app/packaged/.env
    aws secretsmanager get-secret-value --secret-id "cat/env/core" --query SecretString --output text --region eu-west-1 >> $DIR/app/packaged/.env
    printf "\n# END ENV CORE SETTINGS\n" >> $DIR/app/packaged/.env
    echo "Getting your env additions"
    printf "\n# ENV ADDITIONS\n" >> $DIR/app/packaged/.env
    aws secretsmanager get-secret-value --secret-id "cat/${APP_NAME}-uat/additions" --query SecretString --output text --region eu-west-1 >> $DIR/app/packaged/.env
    printf "\n# END ENV ADDITIONS\n" >> $DIR/app/packaged/.env
    echo "Copy over uat supervisor"
    cp $DIR/app/uat_supervisor.ini $DIR/app/supervisor.ini
    echo "Building UAT Image"
    docker build -t $APP_NAME .
    docker tag $APP_NAME:latest 364215618558.dkr.ecr.eu-west-1.amazonaws.com/$APP_NAME:uat_$HASH
    echo "Pushing up uat image using has uat_$HASH"
    docker push 364215618558.dkr.ecr.eu-west-1.amazonaws.com/$APP_NAME:uat_$HASH
fi


echo "Setting up filebeat production make sure file exists"
cp $DIR/app/filebeat_production.yml $DIR/app/filebeat.yml

echo "Running Production build"
echo "Getting ENV file from Secrets cat/${APP_NAME}-production/core"
aws secretsmanager get-secret-value --secret-id "cat/${APP_NAME}-production/core" --query SecretString --output text --region eu-west-1 > $DIR/app/packaged/.env
echo "Getting Core Env Settings"
printf "\n# ENV CORE SETTINGS\n" >> $DIR/app/packaged/.env
aws secretsmanager get-secret-value --secret-id "cat/env/core" --query SecretString --output text --region eu-west-1 >> $DIR/app/packaged/.env
printf "\n# END ENV CORE SETTINGS\n" >> $DIR/app/packaged/.env
echo "Getting your env additions"
printf "\n# ENV ADDITIONS\n" >> $DIR/app/packaged/.env
aws secretsmanager get-secret-value --secret-id "cat/${APP_NAME}-production/additions" --query SecretString --output text --region eu-west-1 >> $DIR/app/packaged/.env
printf "\n# END ENV ADDITIONS\n" >> $DIR/app/packaged/.env
echo "Copy over production supervisor"
cp $DIR/app/production_supervisor.ini $DIR/app/supervisor.ini
echo "Building Production Image"
docker build -t $APP_NAME .
docker tag $APP_NAME:latest 364215618558.dkr.ecr.eu-west-1.amazonaws.com/$APP_NAME:production_$HASH
echo "Pushing up production image using has production_$HASH"
docker push 364215618558.dkr.ecr.eu-west-1.amazonaws.com/$APP_NAME:production_$HASH

