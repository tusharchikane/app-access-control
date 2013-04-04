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

	public function testGetServiceLocator(){
		$this->assertInstanceOf('\Zend\ServiceManager\ServiceLocatorInterface',$this->accessControlAuthenticationService->getServiceLocator());
	}

	public function testGetAdapter(){
		$this->assertInstanceOf('\BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface',$this->accessControlAuthenticationService->getAdapter('LocalAuth'));
	}

	public function testGetAuthenticationService(){
		$this->assertInstanceOf('\Zend\Authentication\AuthenticationService',$this->accessControlAuthenticationService->getAuthenticationService());
	}

	public function testAuthenticate(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Wrong authentication
		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_IDENTITY_WRONG,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','wrong','valid-credential')
		);

		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_IDENTITY_WRONG,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','valid@test.com','wrong-credential')
		);

		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_IDENTITY_WRONG,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','pending','wrong-credential')
		);

		//Pending authentication
		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_AUTH_ACCESS_STATE_PENDING,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','pending','pending-credential')
		);

		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_AUTH_ACCESS_STATE_PENDING,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','pending@test.com','pending-credential')
		);

		//Valid authentication
		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_VALID,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','valid','valid-credential')
		);

		$this->assertEquals(
			\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_VALID,
			$this->accessControlAuthenticationService->authenticate('LocalAuth','valid@test.com','valid-credential')
		);
	}

	public function testHasIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Unlogged
		$this->accessControlAuthenticationService->clearIdentity();
		$this->assertFalse($this->accessControlAuthenticationService->hasIdentity());

		//Logged
		$this->accessControlAuthenticationService->authenticate('LocalAuth','valid','valid-credential');
		$this->assertTrue($this->accessControlAuthenticationService->hasIdentity());
	}

	public function testGetIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		$this->accessControlAuthenticationService->authenticate('LocalAuth','valid','valid-credential');
		$this->assertEquals(1,$this->accessControlAuthenticationService->getIdentity());
	}

	public function testClearIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		$this->accessControlAuthenticationService->authenticate('LocalAuth','valid','valid-credential');
		$this->assertInstanceOf('\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService',$this->accessControlAuthenticationService->clearIdentity());
	}
}