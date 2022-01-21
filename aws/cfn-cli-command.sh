#!/bin/bash

# vars
CMD="dumy"
# Check app_name argument has been supplied
if [ $# -gt 0 ]; then
    APP_NAME=$1
    shift
else
    echo "Error: missing app_name argument"
    echo "Usage: bash ./aws/cfn-cli-command.sh app_name"
    exit 1
fi

# Check parameters.json file exists
if [ ! -f "aws/parameters.json" ]; then
    echo "Error: aws/parameters.json does not exist."
    echo "Copy aws/parameters.json.example to parameters.json, and set values."
    exit 1
fi

# Check tag.json file exists
if [ ! -f "aws/tag.json" ]; then
    echo "Error: aws/tag.json does not exist."
    echo "Copy aws/tag.json.example to tag.json, and set values."
    exit 1
fi

# Parse the args
while (( "$#" )); do
  case "$1" in
    -o|--operation|--operation="create")
      if [ "${1##--operation=}" != "$1" ]; then
        OP="${1##--operation=}"
        shift
      else
        OP=$2
        shift 2
      fi
      ;;
    --)
      shift
      break
      ;;
    -*|--*=)
      shift
      ;;
    *)
      shift
      ;;
  esac
done
echo "Operation: $OP"

if [ "$OP" == "create" ] || [ "$OP" == "update" ]; then
    # Create the stack
    echo "Executing stack ${OP} command ..."
    CMD=`aws cloudformation ${OP}-stack --stack-name ${APP_NAME} \
        --template-body file:///$(pwd)/aws/web-template.yml \
        --tags file:///$(pwd)/aws/tag.json \
        --parameters file:///$(pwd)/aws/parameters.json \
        --capabilities CAPABILITY_IAM CAPABILITY_NAMED_IAM CAPABILITY_AUTO_EXPAND \
        --role-arn arn:aws:iam::364215618558:role/service/cloudformation-builder-role`
elif [ "$OP" == "delete" ]; then
    # Delete the stack
    echo "Executing stack delete command ..."
    CMD=`aws cloudformation ${OP}-stack --stack-name ${APP_NAME} \
        --role-arn arn:aws:iam::364215618558:role/service/cloudformation-builder-role`
else
    echo "Error: invalid operation"
    echo "Usage: bash ./aws/cfn-cli-command.sh app_name -o|--operation|--operation=\"create\"|\"update\"|\"delete\""
    exit 1
fi 

exit 0