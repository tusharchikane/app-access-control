<?php
namespace BoilerAppAccessControlTest\Service;
class AccessControlServiceTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase{

	/**
	 * @var \BoilerAppAccessControl\Service\AccessControlService
	 */
	protected $accessControlService;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
		$this->accessControlService = new \BoilerAppAccessControl\Service\AccessControlService();
		$this->accessControlService->setServiceLocator($this->getServiceManager());
	}

	public function testGetAuthenticatedAuthAccess(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authentication
		$this->getServiceManager()->get('AuthenticationService')->authenticate('LocalAuth','valid@test.com','valid-credential');

		$this->assertInstanceOf('BoilerAppAccessControl\Entity\AuthAccessEntity',$this->accessControlService->getAuthenticatedAuthAccess());
	}

	/**
	 * @expectedException RuntimeException
	 */
	public function testGetAuthenticatedAuthAccessWithUnknownIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Wrong Authentication
		$this->getServiceManager()->get('AccessControlAuthenticationService')->getStorage()->write('wrong');

		$this->accessControlService->getAuthenticatedAuthAccess();
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetAuthenticatedAuthAccessWithPendingIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Wrong Authentication
		$this->getServiceManager()->get('AccessControlAuthenticationService')->getStorage()->write(2);

		$this->accessControlService->getAuthenticatedAuthAccess();
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testGetAuthAccessFromIdentityWithWrongIdentity(){
		$this->accessControlService->getAuthAccessFromIdentity(null);
	}

	public function testIsEmailIdentityAvailable(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate
		$this->getServiceManager()->get('AuthenticationService')->authenticate('LocalAuth','valid@test.com','valid-credential');

		$this->assertEquals('L\'adresse email "valid@test.com" est identique',$this->accessControlService->isEmailIdentityAvailable('valid@test.com'));

		$this->assertEquals('L\'adresse email "pending@test.com" est indisponible',$this->accessControlService->isEmailIdentityAvailable('pending@test.com'));

		$this->assertTrue($this->accessControlService->isEmailIdentityAvailable('available@test.com'));
	}

	public function testIsUsernameIdentityAvailable(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		$this->assertEquals('L\'identifiant "valid" est identique',$this->accessControlService->isUsernameIdentityAvailable('valid'));

		$this->assertEquals('L\'identifiant "pending" est indisponible',$this->accessControlService->isUsernameIdentityAvailable('pending'));

		$this->assertTrue($this->accessControlService->isUsernameIdentityAvailable('available'));
	}
}