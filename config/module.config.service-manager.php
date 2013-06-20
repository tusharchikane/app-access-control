<?php
return array(
	'invokables' => array(
		'AccessControlService' => 'BoilerAppAccessControl\Service\AccessControlService',
		'AuthAccessService' => 'BoilerAppAccessControl\Service\AuthAccessService',
		'AuthenticationService' => 'BoilerAppAccessControl\Service\AuthenticationService',
		'RegistrationService' => 'BoilerAppAccessControl\Service\RegistrationService'
	),
	'factories' => array(
		'AccessControlAuthenticationService' => 'BoilerAppAccessControl\Factory\AccessControlAuthenticationServiceFactory',
		'AuthenticationStorage' => 'BoilerAppAccessControl\Factory\AuthenticationStorageFactory',
		'AuthenticationDoctrineAdapter' => 'BoilerAppAccessControl\Factory\AuthenticationDoctrineAdapterFactory',
		'ChangeAuthAccessCredentialForm' => 'BoilerAppAccessControl\Factory\ChangeAuthAccessCredentialFormFactory',
		'ChangeAuthAccessEmailIdentityForm' => 'BoilerAppAccessControl\Factory\ChangeAuthAccessEmailIdentityFormFactory',
		'ChangeAuthAccessUsernameIdentityForm' => 'BoilerAppAccessControl\Factory\ChangeAuthAccessUsernameIdentityFormFactory',
		'RemoveAuthAccessForm' => 'BoilerAppAccessControl\Factory\RemoveAuthAccessFormFactory',
		'AuthenticateForm' => 'BoilerAppAccessControl\Factory\AuthenticateFormFactory',
		'RegisterForm' => 'BoilerAppAccessControl\Factory\RegisterFormFactory',
		'ResetCredentialForm' => 'BoilerAppAccessControl\Factory\ResetCredentialFormFactory',
		'SessionManager' => 'BoilerAppAccessControl\Factory\SessionManagerFactory',
		'SessionContainer' => 'BoilerAppAccessControl\Factory\SessionContainerFactory',
		'Captcha' => 'BoilerAppAccessControl\Factory\CaptchaFactory',
		'Encryptor' => 'BoilerAppAccessControl\Factory\EncryptorFactory',
	),
	'aliases' => array(
		'Zend\Authentication\AuthenticationService' => 'AccessControlAuthenticationService'
	)
);