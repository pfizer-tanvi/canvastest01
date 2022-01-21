import os
import click

def create_and_update_file(params, file_in, file_out):
    with open(file_in, 'r') as file:
        filedata = file.read()

    for param, v in params.items():
        filedata = filedata.replace(param, params[param])

    with open(file_out, 'w') as file:
        file.write(filedata)

def create_param_and_tag_files(params, PROD = True, UAT = False):
    pwd = os.getcwd()

    environments = {
        "staging": True,
        "production": PROD,
        "uat": UAT
    }

    for env, make_it in environments.items():
        if make_it:
            params["ENV"] = env

            if env != "production":
                params["DOMAIN_NAME"] = f"{params['APP_NAME']}-{env}"
            else:
                params["DOMAIN_NAME"] = params['APP_NAME']

            create_and_update_file(
                params,
                f'{pwd}/aws/tags.json',
                f'{pwd}/aws/tags-{env}.json'
            )

            create_and_update_file(
                params,
                f'{pwd}/aws/parameters.json',
                f'{pwd}/aws/parameters-{env}.json'
            )

@click.group()
def cli():
    pass

@cli.command()
def start():

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
        'APP_KEY':'base64:x/VkI+IKQO953Kp6LbmIntjtWddVLbUCFHfYHuTIOh0='
    }

    for param, default in params.items():
        params[param] = click.prompt(param, type=str, default=default)

    prod = click.prompt("You need a Prod environment? Y/n", type=bool)
    uat = click.prompt("You need a UAT environment? Y/n", type=bool)

    create_param_and_tag_files(params, prod, uat)

    print(params)

if __name__ == '__main__':
    cli()