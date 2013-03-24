<?php
return array(
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
	'authentication' => array(
		'storage' => 'AuthenticationStorage',
		'adapters' => array(
			'LocalAuth' => 'AuthenticationDoctrineAdapter',
			'HybridAuth' => 'AuthenticationHybridAuthAdapter'
		)
	),
	'hybrid_auth' =>  array(
		'base_url' => 'BoilerAppAccessControl/hybridauth',

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
	'service_manager' => array(
		'invokables' => array(
			'BoilerAppAccessControlService' => 'BoilerAppAccessControl\Service\BoilerAppAccessControlService',
			'AuthenticationService' => 'BoilerAppAccessControl\Service\AuthenticationService',
			'RegistrationService' => 'BoilerAppAccessControl\Service\RegistrationService'
		),
		'factories' => array(
			'AccessControlAuthenticationService' => 'BoilerAppAccessControl\Factory\BoilerAppAccessControlAuthenticationServiceFactory',
			'AuthenticationStorage' => 'BoilerAppAccessControl\Factory\AuthenticationStorageFactory',
			'AuthenticationDoctrineAdapter' => 'BoilerAppAccessControl\Factory\AuthenticationDoctrineAdapterFactory',
			'AuthenticationHybridAuthAdapter' => 'BoilerAppAccessControl\Factory\AuthenticationHybridAuthAdapterFactory',
			'AuthenticateForm' => 'BoilerAppAccessControl\Factory\AuthenticateFormFactory',
			'RegisterForm' => 'BoilerAppAccessControl\Factory\RegisterFormFactory',
			'ResetCredentialForm' => 'BoilerAppAccessControl\Factory\ResetCredentialFormFactory',
			'SessionManager' => 'BoilerAppAccessControl\Factory\SessionManagerFactory',
		)
	),
	'view_manager' => array(
		'template_path_stack' => array('BoilerAppAccessControl' => __DIR__ . '/../view')
	)
);