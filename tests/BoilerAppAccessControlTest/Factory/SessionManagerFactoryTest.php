<?php
namespace BoilerAppAccessControlTest\Factory;
class SessionManagerFactoryTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase{

	/**
	 * @var \BoilerAppAccessControl\Factory\SessionManagerFactory
	 */
	protected $sessionManagerFactory;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
		$this->sessionManagerFactory = new \BoilerAppAccessControl\Factory\SessionManagerFactory();
	}

	public function testCreateService(){
		$this->assertInstanceof('\Zend\Session\SessionManager',$this->sessionManagerFactory->createService($this->getServiceManager()));
    }
}