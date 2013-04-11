<?php
return array(
	'SessionNamespace' => 'BoilerAppAccessControl',
	'router' => include 'module.config.routes.php',
	'asset_bundle' => include 'module.config.assets.php',
	'doctrine' => include 'module.config.doctrine.php',
	'translator' => include 'module.config.translations.php',
	'messenger' => array(
		'view_manager' => array(
			'template_map' => array(
				'email/registration/confirm-email' => __DIR__ . '/../view/email/registration/confirm-email.phtml',
				'email/authentication/confirm-reset-credential' => __DIR__ . '/../view/email/authentication/confirm-reset-credential.phtml',
				'email/authentication/credential-reset' => __DIR__ . '/../view/email/authentication/credential-reset.phtml'
			)
		)
	),
	'captcha' => array(
		'font' =>  __DIR__.'/../data/fonts/ARIAL.ttf',
		'fsize' => 30,
		'width' => 220,
		'height' => 70,
		'dotNoiseLevel' => 40,
		'lineNoiseLevel' => 3,
		'wordlen' => 6,
		'imgDir' => './public/assets/captcha',
		'imgUrl' => '/assets/captcha/'
	),
	'authentication' => array(
		'storage' => 'AuthenticationStorage',
		'adapters' => array(
			'LocalAuth' => 'AuthenticationDoctrineAdapter',
			'HybridAuth' => 'AuthenticationHybridAuthAdapter'
		),
		'defaultRedirect' => 'AccessControl/Authenticate'
	),
	'hybrid_auth' =>  array(
		'base_url' => 'AccessControl/HybridAuth',

		'providers' => array(
			//Set Redirect URIs = "http://xxxxx/access-control/hybridauth?hauth.done=Google" in google APIs console
			'Google' => array(
				'enabled' => true,
				'keys' => array('id' => '','secret' => ''),
				'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
				'access_type' => 'online',
				'approval_prompt' => 'force'
			),
			'Facebook' => array(
				'enabled' => true,
				'keys' => array( 'id' => '', 'secret' => ''),
				'scope' => array( 'email, user_about_me, offline_access')
			),
			'Twitter' => array(
				'enabled' => true,
				'keys' => array('key' => '', 'secret' => '')
			)
		),
		'debug_mode' => false
	),
	'controllers' => array(
		'invokables' => array(
			'BoilerAppAccessControl\Controller\Registration' => 'BoilerAppAccessControl\Controller\RegistrationController',
			'BoilerAppAccessControl\Controller\Authentication' => 'BoilerAppAccessControl\Controller\AuthenticationController'
		)
	),
	'controller_plugins' => array(
    	'invokables' => array(
    		'RedirectUser' => 'BoilerAppAccessControl\Mvc\Controller\Plugin\RedirectUser',
    	)
    ),
	'service_manager' => array(
		'invokables' => array(
			'AccessControlService' => 'BoilerAppAccessControl\Service\AccessControlService',
			'AuthenticationService' => 'BoilerAppAccessControl\Service\AuthenticationService',
			'RegistrationService' => 'BoilerAppAccessControl\Service\RegistrationService'
		),
		'factories' => array(
			'AccessControlAuthenticationService' => 'BoilerAppAccessControl\Factory\AccessControlAuthenticationServiceFactory',
			'AuthenticationStorage' => 'BoilerAppAccessControl\Factory\AuthenticationStorageFactory',
			'AuthenticationDoctrineAdapter' => 'BoilerAppAccessControl\Factory\AuthenticationDoctrineAdapterFactory',
			'AuthenticationHybridAuthAdapter' => 'BoilerAppAccessControl\Factory\AuthenticationHybridAuthAdapterFactory',
			'AuthenticateForm' => 'BoilerAppAccessControl\Factory\AuthenticateFormFactory',
			'RegisterForm' => 'BoilerAppAccessControl\Factory\RegisterFormFactory',
			'ResetCredentialForm' => 'BoilerAppAccessControl\Factory\ResetCredentialFormFactory',
			'SessionManager' => 'BoilerAppAccessControl\Factory\SessionManagerFactory',
			'SessionContainer' => 'BoilerAppAccessControl\Factory\SessionContainerFactory',
			'Captcha' => 'BoilerAppAccessControl\Factory\CaptchaFactory'
		),
		'aliases' => array(
			'Zend\Authentication\AuthenticationService' => 'AccessControlAuthenticationService'
		)
	),
	'view_manager' => array(
		'template_path_stack' => array('boiler-app-access-control' => __DIR__ . '/../view')
	)
);