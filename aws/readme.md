# AWS Resources Folder

Contains cloudformation templates, aws config, and scripts. Full docs here:

* [Build a new App](https://digitalpfizer.atlassian.net/wiki/spaces/CAP/pages/146834031/Building+the+Initial+Application+For+Stratus)
* [Add stack to existing App](https://digitalpfizer.atlassian.net/wiki/spaces/CAP/pages/3391389713/Adding+a+new+environment+to+an+existing+app)

but this provides a little inline context to the `aws` folder in the repo.

## cfn-cli-command.sh

Contains the `update-stack` command toggle this between `update-stack`, `create-stack` as needed. You can also `delete-stack` if needed to tear down and start over (don't delete in use or production stacks ;)).

## parameters.json

The `cfn-cli-command.sh` to create or update stacks references this file to create tags and billing info. Some info is `REDACTED` from this file. If you need to update or create a new stack you can see current information in the AWS console cloudformation stack tags and secrets.

## Templates

These are the cloudformation templates for the environment stacks. If you need to update one it is best to start by pulling down the current live template from the AWS console or cli for the stack.

## tag.json

Tags for the stack. Some info redacted you can get it back via the AWS console for the stack.

