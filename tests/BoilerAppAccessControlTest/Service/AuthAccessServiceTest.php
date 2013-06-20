<?php
namespace BoilerAppAccessControlTest\Service;
class AuthAccessServiceTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase{

	/**
	 * @var \BoilerAppAccessControl\Service\AuthAccessService
	 */
	protected $authAccessService;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
		$this->authAccessService = new \BoilerAppAccessControl\Service\AuthAccessService();
		$this->authAccessService->setServiceLocator($this->getServiceManager());
	}

	/**
	 * @expectedException \LogicException
	 */
	public function testConfirmChangeAuthenticatedAuthAccessEmailIdentityWithWrongPublicKey(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->authAccessService->confirmChangeAuthenticatedAuthAccessEmailIdentity('wrong','new@test.com');
	}

	/**
	 * @expectedException \LogicException
	 */
	public function testRemoveAuthenticatedAuthAccessWithWrongCredential(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->authAccessService->removeAuthenticatedAuthAccess('wrong');
	}
}