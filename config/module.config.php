<?php
return array(
	'SessionNamespace' => 'BoilerAppAccessControl',
	'router' => include 'module.config.routes.php',
	'asset_bundle' => include 'module.config.assets.php',
	'doctrine' => include 'module.config.doctrine.php',
	'translator' => include 'module.config.translations.php',
	'service_manager' => include 'module.config.service-manager.php',
	'medias' => array(
		\BoilerAppMessenger\Media\Mail\MailMessageRenderer::MEDIA => array(
			'template_map' => array(
				'mail/auth-access/confirm-change-email-identity' => __DIR__ . '/../view/mail/auth-access/confirm-change-email-identity.phtml',
				'mail/authentication/confirm-reset-credential' => __DIR__ . '/../view/mail/authentication/confirm-reset-credential.phtml',
				'mail/authentication/credential-reset' => __DIR__ . '/../view/mail/authentication/credential-reset.phtml',
				'mail/registration/confirm-email' => __DIR__ . '/../view/mail/registration/confirm-email.phtml'
			)
		)
	),
	'captcha' => array(
		'fontDir' => __DIR__.'/../data/fonts',
		'font' =>  'arial.ttf',
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
			'BoilerAppAccessControl\Controller\Authentication' => 'BoilerAppAccessControl\Controller\AuthenticationController',
			'BoilerAppAccessControl\Controller\AuthAccess' => 'BoilerAppAccessControl\Controller\AuthAccessController'
		)
	),
	'controller_plugins' => array(
    	'invokables' => array(
    		'RedirectUser' => 'BoilerAppAccessControl\Mvc\Controller\Plugin\RedirectUser'
    	)
    ),
	'view_manager' => array(
		'template_path_stack' => array('boiler-app-access-control' => __DIR__ . '/../view')
	)
);