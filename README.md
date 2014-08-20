# MamuzContact

[![Build Status](https://travis-ci.org/mamuz/MamuzContact.svg?branch=master)](https://travis-ci.org/mamuz/MamuzContact)
[![Coverage Status](https://coveralls.io/repos/mamuz/MamuzContact/badge.png?branch=master)](https://coveralls.io/r/mamuz/MamuzContact?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mamuz/MamuzContact/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mamuz/MamuzContact/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/504a3291-ab11-4b15-9322-62311bc610a9/mini.png)](https://insight.sensiolabs.com/projects/504a3291-ab11-4b15-9322-62311bc610a9)
[![HHVM Status](http://hhvm.h4cc.de/badge/mamuz/mamuz-contact.png)](http://hhvm.h4cc.de/package/mamuz/mamuz-contact)
[![Dependency Status](https://www.versioneye.com/user/projects/538f787746c4739586000020/badge.svg)](https://www.versioneye.com/user/projects/538f787746c4739586000020)

[![Latest Stable Version](https://poser.pugx.org/mamuz/mamuz-contact/v/stable.svg)](https://packagist.org/packages/mamuz/mamuz-contact)
[![Latest Unstable Version](https://poser.pugx.org/mamuz/mamuz-contact/v/unstable.svg)](https://packagist.org/packages/mamuz/mamuz-contact)
[![Total Downloads](https://poser.pugx.org/mamuz/mamuz-contact/downloads.svg)](https://packagist.org/packages/mamuz/mamuz-contact)
[![License](https://poser.pugx.org/mamuz/mamuz-contact/license.svg)](https://packagist.org/packages/mamuz/mamuz-contact)

## Features

 - This module provides a contact form based on ZF2 and Doctrine2.
 - Submitted contact forms will persist in repository.
 - Captcha support is provided to force submitting by humans.
 - Views are twitter-Bootstrap compatible.

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
`MamuzContact` to `modules` in `./config/application.config.php`:

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

```sh
./vendor/bin/doctrine-module orm:schema-tool:update
```

## Configuration

This module is usable out of the box, but you can overwrite default configuration
by adding a config file in `./config/autoload` directory.
For default configuration see
[`module.config.php`](https://github.com/mamuz/MamuzContact/blob/master/config/module.config.php)

## Captcha Support

Create a new config file and place it to `./config/autoload` directory and
insert configuration array for Zend Captcha form element factory.
Array must be indexed by key `captcha`, for e.g.:

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

## Workflow

After filtering and validation of user input a new contact entity
will persist in repository `MamuzContact`.

## Events

For the sake of simplicity `Event` is used for
FQN [`MamuzContact\EventManager\Event`](https://github.com/mamuz/MamuzContact/blob/master/src/MamuzContact/EventManager/Event.php).

The following events are triggered by `Event::IDENTIFIER` *mamuz-contact*:

Name           | Constant                  | Description
-------------- | ------------------------- | -----------
*persist.pre*  | `Event::PRE_PERSISTENCE`  | Before contact entity persistence
*persist.post* | `Event::POST_PERSISTENCE` | After contact entity persistence
