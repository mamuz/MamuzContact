# MamuzContact

[![Build Status](https://travis-ci.org/mamuz/MamuzContact.svg?branch=master)](https://travis-ci.org/mamuz/MamuzContact)
[![Dependency Status](https://www.versioneye.com/user/projects/538f787746c4739586000020/badge.svg)](https://www.versioneye.com/user/projects/538f787746c4739586000020)
[![Coverage Status](https://coveralls.io/repos/mamuz/MamuzContact/badge.png?branch=master)](https://coveralls.io/r/mamuz/MamuzContact?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mamuz/MamuzContact/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mamuz/MamuzContact/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/504a3291-ab11-4b15-9322-62311bc610a9/mini.png)](https://insight.sensiolabs.com/projects/504a3291-ab11-4b15-9322-62311bc610a9)
[![HHVM Status](http://hhvm.h4cc.de/badge/mamuz/mamuz-contact.png)](http://hhvm.h4cc.de/package/mamuz/mamuz-contact)

[![Latest Stable Version](https://poser.pugx.org/mamuz/mamuz-contact/v/stable.svg)](https://packagist.org/packages/mamuz/mamuz-contact)
[![Total Downloads](https://poser.pugx.org/mamuz/mamuz-contact/downloads.svg)](https://packagist.org/packages/mamuz/mamuz-contact)
[![Latest Unstable Version](https://poser.pugx.org/mamuz/mamuz-contact/v/unstable.svg)](https://packagist.org/packages/mamuz/mamuz-contact)
[![License](https://poser.pugx.org/mamuz/mamuz-contact/license.svg)](https://packagist.org/packages/mamuz/mamuz-contact)

## Domain

 - This module provides a contact form.
 - Submitted contact requests will persist in a database.
 - To force submit by humans captcha support is provided.
 - Contact Form is rendered by twitter-bootstrap viewhelper.
 - Bootstrap 2/3 compatible.

## Installation

The recommended way to install
[`mamuz/mamuz-contact`](https://packagist.org/packages/mamuz/mamuz-contact) is through
[composer](http://getcomposer.org/) by adding dependency to your `composer.json`:

```json
{
    "require": {
        "mamuz/mamuz-contact": "0.*"
    }
}
```

After that run `composer update` and enable this module for ZF2 by adding
`MamuzContact` to the `modules` key in `./config/application.config.php`:

```php
// ...
    'modules' => array(
        'MamuzContact',
    ),
```

This module is based on [`DoctrineORMModule`](https://github.com/doctrine/DoctrineORMModule)
and be sure that you have already [configured database connection](https://github.com/doctrine/DoctrineORMModule).

Create database tables with command line tool provided by
[`DoctrineORMModule`](https://github.com/doctrine/DoctrineORMModule):

### Dump the sql to fire it manually
```sh
./vendor/bin/doctrine-module orm:schema-tool:update --dump-sql
```

### Fire sql automaticly

```sh
./vendor/bin/doctrine-module orm:schema-tool:update --force
```

## Configuration

This module is already configured out of the box, but you can overwrite it by
adding a config file in `./config/autoload` directory.
For default configuration see
[`module.config.php`](https://github.com/mamuz/MamuzContact/blob/master/config/module.config.php)

## Captcha Support

Create a new config file and place it to `./config/autoload` directory.
Insert an array with options for the Zend Captcha form element factory.
Options array must have the key `captcha`, for e.g.:

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

Register your domain to [`Google ReCaptcha WebService`](http://recaptcha.net/) to
create a private key and a public key. Be sure that private key will not commit to VCS.
Usage of Recaptcha requires [`ZendService_Recaptcha`](https://github.com/zendframework/ZendService_ReCaptcha).

## Workflow and Events

After filtering and validation of user input a new contact entity will persist in database table `MamuzContact`.
Persistence is intercepted by triggering pre- and post-events:

- `persist.pre` @ `MamuzContact\Service\Command`
- `persist.post` @ `MamuzContact\Service\Command`
