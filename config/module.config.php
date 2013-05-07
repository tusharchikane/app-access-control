<?php
return array(
	'SessionNamespace' => 'BoilerAppAccessControl',
	'router' => include 'module.config.routes.php',
	'asset_bundle' => include 'module.config.assets.php',
	'doctrine' => include 'module.config.doctrine.php',
	'translator' => include 'module.config.translations.php',
	'medias' => array(
		\BoilerAppMessenger\Media\Mail\MailMessageRenderer::MEDIA => array(
			'template_map' => array(
				'mail/registration/confirm-email' => __DIR__ . '/../view/mail/registration/confirm-email.phtml',
				'mail/authentication/confirm-reset-credential' => __DIR__ . '/../view/mail/authentication/confirm-reset-credential.phtml',
				'mail/authentication/credential-reset' => __DIR__ . '/../view/mail/authentication/credential-reset.phtml'
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
			'LocalAuth' => 'AuthenticationDoctrineAdapter'
		),
		'defaultRedirect' => 'AccessControl/Authenticate'
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