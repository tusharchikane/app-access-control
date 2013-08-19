<?php
return array(
    'assets' => array(
    	'BoilerAppAccessControl' => array(
	    	'BoilerAppAccessControl\Controller\Registration' => array(
	    		'register' => array('js' => array(
	    			__DIR__ . '/../assets/js/Validator/auth-access-identities.js',
	    			__DIR__ . '/../assets/js/Controller/AccessControlIdentityAwareController.js',
	    			__DIR__ . '/../assets/js/Controller/RegistrationRegisterController.js',
	    			'@zfRootPath/vendor/nak5ive/Form.PasswordStrength/Source/Form.PasswordStrength.js',
	    			__DIR__ . '/../assets/js/Behavior/Form.PasswordStrength.js'
	    		))
	    	),
	    	'BoilerAppAccessControl\Controller\Authentication' => array(
	    		'js' => array(__DIR__ . '/../assets/js/Controller/AuthenticationAuthenticateController.js')
	    	),
	    	'BoilerAppAccessControl\Controller\AuthAccess' => array(
	    		'index' => array('js' => array(
	    			__DIR__ . '/../assets/js/Validator/auth-access-identities.js',
	    			__DIR__ . '/../assets/js/Controller/AccessControlIdentityAwareController.js',
	    			__DIR__ . '/../assets/js/Controller/AuthAccessIndexController.js',
	    			'@zfRootPath/vendor/nak5ive/Form.PasswordStrength/Source/Form.PasswordStrength.js',
	    			__DIR__ . '/../assets/js/Behavior/Form.PasswordStrength.js'
	    		))
	    	)
    	)
    )
);