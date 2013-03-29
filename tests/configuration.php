<?php
return array(
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
);