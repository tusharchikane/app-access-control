<?php
return array(
	'asset_bundle' => array(
		'cachePath' => __DIR__.'/_files/cache',
		'cacheUrl' => '@zfBaseUrl/cache/',
		'assetsPath' => null
	),
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
	'messenger' => array(
		'system_user' => array(
			'email' => 'test-system@test.com',
			'name' => 'Test System'
		),
		'transporters' => array(
			\BoilerAppMessenger\Service\MessengerService::MEDIA_EMAIL => function(){
				return new \BoilerAppMessenger\Mail\Transport\File(new \Zend\Mail\Transport\FileOptions(array(
						'path' => __DIR__ . '/_files/mails'
				)));
			}
		)
	),
	'service_manager' => array(
		'factories' => array(
			'Logger' => function(){
				$oLogger = new \Zend\Log\Logger();
				return $oLogger->addWriter(new \Zend\Log\Writer\Stream(STDERR));
			},
			'InlineStyleProcessor' => function(){
				return \BoilerAppMessenger\StyleInliner\Processor\InlineStyleProcessor::factory(array('baseDir' => __DIR__.'/_files'));
			}
		)
	)
);