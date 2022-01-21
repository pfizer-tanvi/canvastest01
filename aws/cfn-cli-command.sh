aws cloudformation create-stack --stack-name APP_NAME \
--template-body file:///$(pwd)/aws/web-template.yml \
--tags file:///$(pwd)/aws/tag.json \
--parameters file:///$(pwd)/aws/parameters.json \
--capabilities CAPABILITY_IAM CAPABILITY_NAMED_IAM CAPABILITY_AUTO_EXPAND