<?php
return array(
	'driver' => array(
		'BoilerAppAccessControl_driver' => array(
			'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
			'cache' => 'array',
			'paths' => array(__DIR__.'/../src/BoilerAppAccessControl/Entity')
		),
		'orm_default' => array(
			'drivers' => array(
				'BoilerAppAccessControl\Entity' => 'BoilerAppAccessControl_driver'
			)
		)
	),
	'configuration' => array(
		'orm_default' => array(
			'types' => array(
				'authaccessstateenum' => 'BoilerAppAccessControl\Doctrine\DBAL\Types\AuthAccessStateEnumType'
			)
		)
	)
);