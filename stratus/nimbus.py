import os
import click
import toml
from shutil import copyfile
import boto3

STRATUS_CONFIG = f"./stratus/stratusconfig.toml"

def get_params(config_env):
    parameters = []
    for param_key, param_value in config_env["parameters"].items():
        parameters.append({
            'ParameterKey': param_key,
            'ParameterValue': param_value,
            'UsePreviousValue': True
        })
    return parameters

def get_tags(config_env):
    tags = []
    for tag_key, tag_value in config_env['tags'].items():
        tags.append({
            'Key': tag_key,
            'Value': tag_value
        })
    return tags

def update_stack(env):
    config = load_config()
    parameters = get_params(config[env])
    tags = get_tags(config[env])

    client = boto3.client('cloudformation', region_name=config[env]['region'])

    client.update_stack(
        StackName=config[env]['stack_name'],
        TemplateBody=open(config[env]['template_file']).read(),
        Parameters=parameters,
        TimeoutInMinutes=15,
        Capabilities=config[env]['capabilities'],
        Tags=tags
    )
    click.echo(click.style(f'Updating Stack Now. ', fg='green'))
    cf_url = f"https://{config[env]['region']}.console.aws.amazon.com/cloudformation/home?"
    cf_region = f"region={config[env]['region']}"
    cf_stack = f"#/stacks/stackinfo?stackId={config[env]['stack_id']}"
    link = f"{cf_url}{cf_region}{cf_stack}"
    click.echo(click.style(f'See more here: {link}', fg='green'))


def create_stack(env):
    config = load_config()
    parameters = get_params(config[env])
    tags = get_tags(config[env])

    client = boto3.client('cloudformation', region_name=config[env]['region'])

    response = client.create_stack(
        StackName=config[env]['stack_name'],
        TemplateBody=open(config[env]['template_file']).read(),
        Parameters=parameters,
        TimeoutInMinutes=15,
        Capabilities=config[env]['capabilities'],
        OnFailure='DELETE',
        Tags=tags,
        EnableTerminationProtection=False # TRUE!
    )

    config[env]["stack_id"] = response["StackId"]
    write_config(config)
    click.echo(click.style(f'Creating stack resources now. ', fg='green'))

    cf_url = f"https://{config[env]['region']}.console.aws.amazon.com/cloudformation/home?"
    cf_region = f"region={config[env]['region']}"
    cf_stack = f"#/stacks/stackinfo?stackId={config[env]['stack_id']}"
    link = f"{cf_url}{cf_region}{cf_stack}"

    click.echo(click.style(f'See more here: {link}', fg='green'))


def load_config(stratus_config = STRATUS_CONFIG):
    return toml.load(stratus_config) 

def write_config(config):
    f = open(STRATUS_CONFIG, 'w+')
    toml.dump(config, f)
    f.close()

def create_and_update_file(params, env):
    config = load_config()
    config[env] = config["default"].copy()
    config[env]["template_file"] = "./stratus/web-template.yml"
    config[env]["stack_name"] = f"{params['APP_NAME']}-{params['APP_ENV']}"
    config[env]["region"] = params['AWS_REGION']
    
    config[env]["tags"]["environment"] = params["APP_ENV"]
    config[env]["tags"]["application"] = params["APP_NAME"]
    config[env]["tags"]["billing_ref"] = params["BILLING_REF"]
    config[env]["tags"]["parent_project"] = params["PARENT_PROJECT"]
    config[env]["tags"]["key_contact"] = params["KEY_CONTACT"]
    config[env]["tags"]["CostCenterID"] = params["COST_CENTRE"]
    config[env]["parameters"]["AppEnv"] = params["APP_ENV"]
    config[env]["parameters"]["AppName"] = params["APP_NAME"]
    config[env]["parameters"]["PublicSite"] = params["PUBLIC_SITE"]
    config[env]["parameters"]["Version"] = params["TASK_VERSION"]
    config[env]["parameters"]["UniqueDomainName"] = params["DOMAIN_NAME"]
    config[env]["parameters"]["Memory"] = params["MEMORY"]
    config[env]["parameters"]["CognitoUserPoolId"] = params["USER_POOL"]
    config[env]["parameters"]["DesiredCount"] = params["DESIRED_COUNT"]
    config[env]["parameters"]["KmsMasterKeyId"] = params["KMS_KEY"]

    write_config(config)

def create_param_and_tag_files(params, PROD = True, UAT = False):
    environments = {
        "staging": True,
        "production": PROD,
        "uat": UAT
    }
    for env, make_it in environments.items():
        if make_it:
            params["APP_ENV"] = env
            if env != "production":
                params["DOMAIN_NAME"] = f"{params['APP_NAME']}-{env}.digitalpfizer.com"
            else:
                params["DOMAIN_NAME"] = f"{params['APP_NAME']}.digitalpfizer.com"
            create_and_update_file(params, env)
    
    config = load_config()
    del(config['default'])
    write_config(config)

@click.group()
def cli():
    pass

@cli.command()
@click.option('--env', default='staging', help='Which environment do you want to deploy?')
def deploy(env):
    click.echo(click.style(f'Deploying {env}', fg='green'))
    config = load_config()

    if env not in config:
        click.echo(click.style(f'{env} not found in the stratusconfig.toml', fg='red'))
        return 

    if config[env]["stack_id"] == "":
        click.echo(click.style(f'No stack found, building {env}', fg='green'))
        return create_stack(env)
    
    click.echo(click.style(f'Stack found! updating {env}', fg='green'))
    return update_stack(env)
    

@cli.command()
def init():
    click.echo(click.style(f'Let\'s build a new app!', fg='green'))
    click.echo(click.style(f'First, lets get the param and tag details...', fg='green'))
    params = {
        'APP_NAME':'stratus-core-web',
        'BILLING_REF':'CLDAPP-STRATCOREWEB',
        'PARENT_PROJECT':'CLDAPP',
        'KEY_CONTACT':'Jamie Hook',
        'COST_CENTRE':'0002321520',
        'USER_POOL': 'eu-west-1_XqKGA2Dyi',
        'MEMORY':'1024',
        'KMS_KEY': 'arn:aws:kms:eu-west-1:364215618558:key/a7db586c-e3f4-4813-8018-2f6f6c8f702c',
        'PUBLIC_SITE': 'no',
        'TASK_VERSION': '001',
        'DESIRED_COUNT': '0',
        'AWS_REGION': 'eu-west-1'
    }

    for param, default in params.items():
        params[param] = click.prompt(param, type=str, default=default)

    prod = click.prompt("You need a Prod environment? Y/n", type=bool)
    uat = click.prompt("You need a UAT environment? Y/n", type=bool)

    create_param_and_tag_files(params, prod, uat)

if __name__ == '__main__':
    cli()
