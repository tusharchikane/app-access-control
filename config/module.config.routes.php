<?php
return array(
	'routes' => array(
		'AccessControl' => array(
			'type' => 'Zend\Mvc\Router\Http\Literal',
			'options' => array('route' => '/access-control'),
			'may_terminate' => true,
			'child_routes' => array(
				'AuthAccess' => array(
					'type' => 'Zend\Mvc\Router\Http\Literal',
					'options' => array(
						'route' => '/auth-access',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\AuthAccess',
							'action' => 'index'
						)
					),
					'may_terminate' => true,
					'child_routes' => array(
						'ChangeEmailIdentity' => array(
							'type' => 'Zend\Mvc\Router\Http\Literal',
							'options' => array(
								'route' => '/change-email-identity',
								'defaults' => array(
									'controller' => 'BoilerAppAccessControl\Controller\AuthAccess',
									'action' => 'changeEmailIdentity'
								)
							)
						),
						'ConfirmChangeEmailIdentity' => array(
							'type' => 'Zend\Mvc\Router\Http\Segment',
							'options' => array(
								'route' => '/confirm-change-email-identity/:public_key/:email_identity',
								'defaults' => array(
									'controller' => 'BoilerAppAccessControl\Controller\AuthAccess',
									'action' => 'confirmChangeEmailIdentity'
								)
							)
						),
						'ChangeUsernameIdentity' => array(
							'type' => 'Zend\Mvc\Router\Http\Literal',
							'options' => array(
								'route' => '/change-username-identity',
								'defaults' => array(
									'controller' => 'BoilerAppAccessControl\Controller\AuthAccess',
									'action' => 'changeUsernameIdentity'
								)
							)
						),
						'ChangeCredential' => array(
							'type' => 'Zend\Mvc\Router\Http\Literal',
							'options' => array(
								'route' => '/change-credential',
								'defaults' => array(
									'controller' => 'BoilerAppAccessControl\Controller\AuthAccess',
									'action' => 'changeCredential'
								)
							)
						)
					)
				),
				'Register' => array(
					'type' => 'Zend\Mvc\Router\Http\Segment',
					'options' => array(
						'route' => '/register[/:service]',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\Registration',
							'action' => 'register'
						)
					)
				),
				'CheckEmailIdentityAvailability' => array(
					'type' => 'Zend\Mvc\Router\Http\Literal',
					'options' => array(
						'route' => '/check-email-identity-availability',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\Registration',
							'action' => 'checkEmailIdentityAvailability'
						)
					)
				),
				'CheckUsernameIdentityAvailability' => array(
					'type' => 'Zend\Mvc\Router\Http\Literal',
					'options' => array(
						'route' => '/check-username-identity-availability',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\Registration',
							'action' => 'checkUsernameIdentityAvailability'
						)
					)
				),
				'ConfirmEmail' => array(
					'type' => 'Zend\Mvc\Router\Http\Segment',
					'options' => array(
						'route' => '/confirm-email/:public_key/:email_identity',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\Registration',
							'action' => 'confirmEmail'
						)
					)
				),
				'ResendConfirmationEmail' => array(
					'type' => 'Zend\Mvc\Router\Http\Literal',
					'options' => array(
						'route' => '/resend-confirmation-email',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\Registration',
							'action' => 'resendConfirmationEmail'
						)
					)
				),
				'Authenticate' => array(
					'type' => 'Zend\Mvc\Router\Http\Segment',
					'options' => array(
						'route' => '/authenticate[/:service]',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\Authentication',
							'action'  => 'authenticate'
						)
					)
				),
				'ForgottenCredential' => array(
					'type' => 'Zend\Mvc\Router\Http\Literal',
					'options' => array(
						'route' => '/forgotten-credential',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\Authentication',
							'action' => 'forgottenCredential'
						)
					)
				),
				'ResetCredential' => array(
					'type' => 'Zend\Mvc\Router\Http\Segment',
					'options' => array(
						'route' => '/reset-credential/:public_key/:email_identity',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\Authentication',
							'action' => 'resetCredential'
						)
					)
				),
				'Logout' => array(
					'type' => 'Zend\Mvc\Router\Http\Literal',
					'options' => array(
						'route' => '/logout',
						'defaults' => array(
							'controller' => 'BoilerAppAccessControl\Controller\Authentication',
							'action' => 'logout'
						)
					)
				)
			)
		)
	)
);