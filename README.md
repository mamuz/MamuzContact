# MamuzContact

[![Build Status](https://travis-ci.org/mamuz/MamuzContact.svg?branch=master)](https://travis-ci.org/mamuz/MamuzContact)
[![Dependency Status](https://www.versioneye.com/user/projects/538f787d46c47346e700001e/badge.svg)](https://www.versioneye.com/user/projects/538f787d46c47346e700001e)
[![Coverage Status](https://coveralls.io/repos/mamuz/MamuzContact/badge.png?branch=master)](https://coveralls.io/r/mamuz/MamuzContact?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mamuz/MamuzContact/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mamuz/MamuzContact/?branch=master)

[![Latest Stable Version](https://poser.pugx.org/mamuz/mamuz-contact/v/stable.svg)](https://packagist.org/packages/mamuz/mamuz-contact)
[![Total Downloads](https://poser.pugx.org/mamuz/mamuz-contact/downloads.svg)](https://packagist.org/packages/mamuz/mamuz-contact)
[![Latest Unstable Version](https://poser.pugx.org/mamuz/mamuz-contact/v/unstable.svg)](https://packagist.org/packages/mamuz/mamuz-contact)
[![License](https://poser.pugx.org/mamuz/mamuz-contact/license.svg)](https://packagist.org/packages/mamuz/mamuz-contact)

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
