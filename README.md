ZF2 BoilerApp "Access control" module
=====================

[![Build Status](https://travis-ci.org/zf2-boiler-app/app-access-control.png?branch=master)](https://travis-ci.org/zf2-boiler-app/app-access-control)

Created by Neilime

NOTE : This module is in heavy development, it's not usable yet.
If you want to contribute don't hesitate, I'll review any PR.

Introduction
------------

__ZF2 BoilerApp "Access control" module__ is a Zend Framework 2 module

Requirements
------------

* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)

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
        "zf2-boiler-app/app-access-control": "dev-master"
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