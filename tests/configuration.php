<?php
return array(
	'translator' => array(
		'locale' => 'fr_FR'
	),
	'authentication' => array(
		'storage' => 'AuthenticationStorage',
		'adapters' => array(
			'LocalAuth' => 'AuthenticationDoctrineAdapter',
			'HybridAuth' => 'AuthenticationHybridAuthAdapter'
		)
	),
	'hybrid_auth' =>  array(
		'base_url' => 'AccessControl/HybridAuth',
		'providers' => array(
			'Google' => array(
				'enabled' => true,
				'keys' => array('id' => '','secret' => ''),
				'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
				'access_type' => 'online',
				'approval_prompt' => 'force'
			)
		),
		'debug_mode' => false
	),
	'doctrine' => array(
		'connection' => array(
			'orm_default' => array(
				'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
				'params' => array(
					'host'     => 'localhost',
					'user'     => 'root',
					'password' => '',
					'dbname'   => 'doctrine_tests'
				)
			)
		)
	),
	'templating' => array(
		'template_map' => array(
			'default' => array(
				'template' => 'layout/layout'
			)
		)
	),
	'view_manager' => array(
		'template_map' => array(
			'layout/layout' => __DIR__ . '/_files/view/layout/layout.phtml'
		)
	),
	'service_manager' => array(
		'factories' => array(
			'Logger' => function(){
				$oLogger = new \Zend\Log\Logger();
				return $oLogger->addWriter(new \Zend\Log\Writer\Stream(STDERR));
			}
		)
	)
);