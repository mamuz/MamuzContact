# MamuzContact

## Installation

Run doctrine orm command line to create database table:

Dump the sql..
```sh
./vendor/bin/doctrine-module  orm:schema-tool:update --dump-sql
```
Force update
```sh
./vendor/bin/doctrine-module  orm:schema-tool:update --force
```
In usage of environment variable..
```sh
export APPLICATION_ENV=development; ./vendor/bin/doctrine-module  orm:schema-tool:update
```

## Captcha Support

### Configuration

Create a new config file and place it to config/autoload. Insert an array with options
for the Zend Captcha form element factory. e.g:

```php
return array(
    'captcha' => array(
        'type'       => 'Zend\Form\Element\Captcha',
        'name'       => 'captcha',
        'options'    => array(
            'label'   => 'Please verify you are human',
            'captcha' => array(
                'class'   => 'recaptcha',
                'options' => array(
                    'pubkey'  => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                    'privkey' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                ),
            ),
        ),
        'attributes' => array(
            'required' => 'required'
        ),
    ),
);
```

### Requirement for Google ReCaptcha WebService

Register your domain to [Google ReCaptcha WebService](http://recaptcha.net/) to
create a private key and a public key. Be sure that private key will not commit to VCS.
Usage of Recaptcha requires [ZendService_Recaptcha](https://github.com/zendframework/ZendService_ReCaptcha).
Add this dependency to composer.json.

## Workflow

After filtering and validation of user input a new contact entity will be stored in database.
Storing is intercepted by trigger post and pre events:

- persist.pre
- persist.post
