#!/usr/bin/env bash

# Bail out on first error
set -e

AWSRegion=${AWS_REGION:-"eu-west-1"}
AWSAccountId=${AWS_ACCOUNT_ID:-"364215618558"}
printf '[{"name":"%s-staging","imageUri":"%s.dkr.ecr.%s.amazonaws.com/%s:latest"}]' $APP_NAME $AWSAccountId $AWSRegion $APP_NAME > imagedefinitions.json
echo "Zipping up files"
zip --quiet -r latest ./
echo "Sending zip to aws to trigger build"
aws --region=eu-west-1 s3 cp latest.zip s3://det-${APP_NAME}/provision/staging/latest.zip

echo "Going to poll for job status"
sudo pip3 install boto3
echo "Done with boto3 install going to check pipeline"
python3 check_pipeline.py ${APP_NAME}-${APP_ENV}

