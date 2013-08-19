ZF2 BoilerApp "Access control" module
=====================

[![Build Status](https://travis-ci.org/zf2-boiler-app/app-access-control.png?branch=master)](https://travis-ci.org/zf2-boiler-app/app-access-control)
[![Latest Stable Version](https://poser.pugx.org/zf2-boiler-app/app-access-control/v/stable.png)](https://packagist.org/packages/zf2-boiler-app/app-access-control)
[![Total Downloads](https://poser.pugx.org/zf2-boiler-app/app-access-control/downloads.png)](https://packagist.org/packages/zf2-boiler-app/app-access-control)
![Code coverage](https://raw.github.com/zf2-boiler-app/app-test/master/ressources/100%25-code-coverage.png "100% code coverage")

NOTE : This module is in heavy development, it's not usable yet.
If you want to contribute don't hesitate, I'll review any PR.

Introduction
------------

__ZF2 BoilerApp "Access control" module__ is a Zend Framework 2 module that provides access control for ZF2 Boiler-App

Requirements
------------

* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)
* [ZF2 BoilerApp "Database" module](https://github.com/zf2-boiler-app/app-db) (latest master)
* [ZF2 BoilerApp "Display" module](https://github.com/zf2-boiler-app/app-display) (latest master)
* [ZF2 BoilerApp "Messenger" module](https://github.com/zf2-boiler-app/app-messenger) (latest master)
* [ZF2 BoilerApp "User" module](https://github.com/zf2-boiler-app/app-user) (latest master)

Installation
------------

### Main Setup

#### By cloning project

1. Clone this project into your `./vendor/` directory.

#### With composer

1. Add this project in your composer.json:

    ```json
    "repositories":[
        {
            "type": "package",
            "package": {
                "version": "dev-master",
                "name": "fortawesome/font-awesome",
                "source": {"url": "https://github.com/FortAwesome/Font-Awesome.git","type": "git","reference": "master"}
            }
        },
        {
            "type": "package",
            "package": {
                "version": "dev-master",
                "name": "fabiomcosta/mootools-meio-mask",
                "source": {"url": "https://github.com/fabiomcosta/mootools-meio-mask.git","type": "git","reference": "master"}
            }
        },
        {
            "type": "package",
            "package": {
                "version": "dev-master",
                "name": "arian/iFrameFormRequest",
                "source": {"url": "https://github.com/arian/iFrameFormRequest.git","type": "git","reference": "master"}
            }
        },
        {
            "type": "package",
            "package": {
                "version": "dev-master",
                "name": "nak5ive/Form.PasswordStrength",
                "source": {"url": "https://github.com/nak5ive/Form.PasswordStrength.git","type": "git","reference": "master"}
            }
        },
        {
	        "type": "vcs",
	        "url": "http://github.com/Nodge/lessphp"
	    }
    ],
    "require": {
        "zf2-boiler-app/app-access-control": "1.0.*"
    }
    ```

2. Now tell composer to download __ZF2 BoilerApp "Access control" module__ by running the command:

    ```bash
    $ php composer.phar update
    ```

#### Post installation

1. Enabling it in your `application.config.php` file.

    ```php
    return array(
        'modules' => array(
            // ...
            'DoctrineModule',
			'DoctrineORMModule',
			'AssetsBundle',
			'TwbBundle',
			'BoilerAppDb',
			'BoilerAppUser',
			'BoilerAppDisplay',
			'BoilerAppMessenger',
			'BoilerAppAccessControl'
        ),
        // ...
    );
    ```

## Features

- Two steps registrations (confirm email adress)
- Login with username or email adress
- Authentication access is independent of the user account 
- An authentication access can be used to access multiple accounts
- An account can be accessed by multiple authentication access