<?php
namespace BoilerAppAccessControlTest\Authentication;
class AccessControlAuthenticationServiceTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase{
	/**
	 * @var \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService
	 */
	protected $accessControlAuthenticationService;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
		$oAccessControlAuthenticationServiceFactory = new \BoilerAppAccessControl\Factory\AccessControlAuthenticationServiceFactory();
		$this->accessControlAuthenticationService = $oAccessControlAuthenticationServiceFactory->createService($this->getServiceManager());
	}

	public function testFactoryWithArrayAdapter(){
		$this->assertInstanceOf('BoilerAppAccessControl\Authentication\AccessControlAuthenticationService',\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(array(
			'adapters' => array(
				array('name' => 'LocalAuth', 'adapter' => 'AuthenticationDoctrineAdapter')
			)
		), $this->getServiceManager()));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFactoryWithWrongTypeAdapter(){
		\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(array(
			'adapters' => array(
				array('name' => 'LocalAuth', 'adapter' => false)
			)
		), $this->getServiceManager());
	}

	/**
	 * @expectedException LogicException
	 */
	public function testFactoryWithUnknownAdapter(){
		\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(array(
			'adapters' => array(
				array('name' => 'LocalAuth', 'adapter' => 'wrong')
			)
		), $this->getServiceManager())->getAdapter('LocalAuth');
	}

	public function testFactoryWithClassnameStorage(){
		$this->assertInstanceOf('BoilerAppAccessControl\Authentication\AccessControlAuthenticationService',\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(array(
			'storage' => 'BoilerAppAccessControl\Authentication\Storage\SessionStorage'
		), $this->getServiceManager()));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFactoryWithWrongTypeStorage(){
		\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(array(
			'storage' => false
		), $this->getServiceManager());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFactoryWithUnknownStorage(){
		\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(array(
			'storage' => 'wrong'
		), $this->getServiceManager());
	}

	public function testGetServiceLocator(){
		$this->assertInstanceOf('\Zend\ServiceManager\ServiceLocatorInterface',$this->accessControlAuthenticationService->getServiceLocator());
	}

	public function testGetAdapter(){
		$this->assertInstanceOf('\BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface',$this->accessControlAuthenticationService->getAdapter('LocalAuth'));
	}


	/**
	 * @expectedException LogicException
	 */
	public function testGetStorageUnset(){
		$oReflectionClass = new \ReflectionClass('BoilerAppAccessControl\Authentication\AccessControlAuthenticationService');
		$oStorage = $oReflectionClass->getProperty('storage');
		$oStorage->setAccessible(true);
		$oStorage->setValue($this->accessControlAuthenticationService, null);
		$this->accessControlAuthenticationService->getStorage();
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetAdapterUnset(){
		$oReflectionClass = new \ReflectionClass('BoilerAppAccessControl\Authentication\AccessControlAuthenticationService');
		$oAdapters = $oReflectionClass->getProperty('adapters');
		$oAdapters->setAccessible(true);
		$oAdapters->setValue($this->accessControlAuthenticationService, array('LocalAuth' => false));

		$this->accessControlAuthenticationService->getAdapter('LocalAuth');
	}

	public function testAuthenticateWithFailureUncategorized(){
		$oAccessControlAuthenticationService = \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(array(
			'adapters' => array(
				array(
					'name' => 'FailAuth',
					'adapter' => 'BoilerAppAccessControlTest\Authentication\Adapter\AuthenticationDoctrineAdapterFail'
				)
			),
			'storage' => 'AuthenticationStorage'
		), $this->getServiceManager());
		$this->assertEquals('fail message',$oAccessControlAuthenticationService->authenticate('FailAuth',\Zend\Authentication\Result::FAILURE_UNCATEGORIZED,array('fail message'),true));
	}

	/**
	 * @expectedException DomainException
	 */
	public function testAuthenticateWithWrongFailureCode(){
		$oAccessControlAuthenticationService = \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(array(
			'adapters' => array(
				array(
					'name' => 'FailAuth',
					'adapter' => 'BoilerAppAccessControlTest\Authentication\Adapter\AuthenticationDoctrineAdapterFail'
				)
			),
			'storage' => 'AuthenticationStorage'
		), $this->getServiceManager());
		$oAccessControlAuthenticationService->authenticate('FailAuth',-666,array(),true);
	}

	/**
	 * @expectedException LogicException
	 */
	public function testAuthenticateFailingWithoutMessages(){
		$oAccessControlAuthenticationService = \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(array(
			'adapters' => array(
				array(
					'name' => 'FailAuth',
					'adapter' => 'BoilerAppAccessControlTest\Authentication\Adapter\AuthenticationDoctrineAdapterFail'
				)
			),
			'storage' => 'AuthenticationStorage'
		), $this->getServiceManager());
		$oAccessControlAuthenticationService->authenticate('FailAuth',\Zend\Authentication\Result::FAILURE_UNCATEGORIZED,array(),true);
	}

	public function testAuthenticate(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Wrong authentication
		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_IDENTITY_WRONG,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','wrong','valid-credential',true)
		);

		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_IDENTITY_WRONG,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','valid@test.com','wrong-credential',true)
		);

		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_IDENTITY_WRONG,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','pending','wrong-credential',true)
		);

		//Pending authentication
		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_AUTH_ACCESS_STATE_PENDING,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','pending','pending-credential',true)
		);

		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_AUTH_ACCESS_STATE_PENDING,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','pending@test.com','pending-credential',true)
		);

		//Valid authentication
		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_VALID,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','valid','valid-credential',true)
		);

		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_VALID,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','valid@test.com','valid-credential',true)
		);
	}

	public function testHasIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Unlogged
		$this->accessControlAuthenticationService->clearIdentity();
		$this->assertFalse($this->accessControlAuthenticationService->hasIdentity());

		//Logged
		$this->accessControlAuthenticationService->authenticate('LocalAuth','valid','valid-credential',true);
		$this->assertTrue($this->accessControlAuthenticationService->hasIdentity());
	}

	public function testGetIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		$this->accessControlAuthenticationService->authenticate('LocalAuth','valid','valid-credential',true);
		$this->assertEquals(1,$this->accessControlAuthenticationService->getIdentity());
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetIdentityWithoutIdentity(){
		$this->accessControlAuthenticationService->clearIdentity()->getIdentity();
	}

	public function testClearIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		$this->accessControlAuthenticationService->authenticate('LocalAuth','valid','valid-credential',true);
		$this->assertInstanceOf('\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService',$this->accessControlAuthenticationService->clearIdentity());
	}
}