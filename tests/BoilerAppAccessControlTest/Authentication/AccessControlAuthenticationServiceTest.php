<?php
namespace BoilerAppAccessControlTest\Authentication;
class AccessControlAuthenticationServiceTest extends \PHPUnit_Framework_TestCase{
	/**
	 * @var \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService
	 */
	protected $accessControlAuthenticationService;

	/**
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp(){
		$oServiceManager = \BoilerAppAccessControlTest\Bootstrap::getServiceManager();
		$aConfiguration = $oServiceManager->get('Config');
		$oAccessControlAuthenticationServiceFactory = new \BoilerAppAccessControl\Factory\AccessControlAuthenticationServiceFactory();
		$this->accessControlAuthenticationService = $oAccessControlAuthenticationServiceFactory->createService($oServiceManager);
	}

	public function testGetServiceLocator(){
		$this->assertInstanceOf('\Zend\ServiceManager\ServiceLocatorInterface',$this->accessControlAuthenticationService->getServiceLocator());
	}

	public function testGetAdapter(){
		$this->assertInstanceOf('\BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface',$this->accessControlAuthenticationService->getAdapter('LocalAuth'));
		$this->assertInstanceOf('\BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface',$this->accessControlAuthenticationService->getAdapter('HybridAuth'));
	}

	public function testGetAuthenticationService(){
		$this->assertInstanceOf('\Zend\Authentication\AuthenticationService',$this->accessControlAuthenticationService->getAuthenticationService());
	}

	public function testAuthenticate(){
		$this->assertEquals('',$this->accessControlAuthenticationService->authenticate('LocalAuth','test','test'));
	}

	public function testHasIdentity(){
		//Logged
		$this->assertTrue($this->accessControlAuthenticationService->hasIdentity());

		//Unlogged
		$this->assertFalse($this->accessControlAuthenticationService->hasIdentity());
	}

	public function testGetIdentity(){
		//Logged
		$this->assertEquals('',$this->accessControlAuthenticationService->getIdentity());

		//Unlogged
		$this->assertEquals('',$this->accessControlAuthenticationService->getIdentity());
	}

	public function testClearIdentity(){
		$this->assertInstanceOf('\BoilerAppAccessControl\Authentication\AccessControlAuthenticationService',$this->accessControlAuthenticationService->clearIdentity());
	}

	public function tearDown(){
		parent::tearDown();
	}
}