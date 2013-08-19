<?php
return array(
	'authentication' => array(
		'storage' => 'AuthenticationStorage',
		'adapters' => array(
			'LocalAuth' => 'AuthenticationDoctrineAdapter'
		),
		'defaultRedirect' => '/'
	),
	'doctrine' => array(
		'connection' => array(
			'orm_default' => array(
				'params' => array(
					'dbname'   => 'app-access-control-tests'
				)
			)
		)
	),
	'messenger' => array(
		'system_user' => array(
			'display_name' => 'Test System',
			'email' => 'test-system@test.com'
		),
		'transporters' => array(
			\BoilerAppMessenger\Media\Mail\MailMessageRenderer::MEDIA => function($oServiceLocator){
				$oMailMessageTransporter = new \BoilerAppMessenger\Media\Mail\MailMessageTransporter();
				return $oMailMessageTransporter
				->setMessageRenderer($oServiceLocator->get('MailMessageRenderer'))
				->setBaseDir(__DIR__)
				->setMailTransporter(new \Zend\Mail\Transport\File(new \Zend\Mail\Transport\FileOptions(array(
					'path' => __DIR__ . '/_files/mails'
				))));
			},
		)
	),
	'captcha' => array(
		'imgDir' => __DIR__.'/_files/captcha'
	),
	'service_manager' => array(
		'factories' => array(
			'CssToInlineStylesProcessor' => function(){
				return \BoilerAppMessenger\StyleInliner\Processor\CssToInlineStylesProcessor::factory(array('baseDir' => __DIR__.DIRECTORY_SEPARATOR.'_files'));
			},
			'SessionManager' => 'BoilerAppAccessControlTest\Authentication\SessionManagerFactory'
		)
	),
	'view_manager' => array(
		'template_map' => array(
			'layout/layout' => __DIR__ . '/_files/view/layout/layout.phtml'
		)
	)
);