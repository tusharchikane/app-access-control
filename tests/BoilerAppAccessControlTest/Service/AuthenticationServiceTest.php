<?php
namespace BoilerAppAccessControlTest\Service;
class AuthenticationServiceTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase{

	/**
	 * @var \BoilerAppAccessControl\Service\AuthenticationService
	 */
	protected $authenticationService;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
		$this->authenticationService = new \BoilerAppAccessControl\Service\AuthenticationService();
		$this->authenticationService->setServiceLocator($this->getServiceManager());
	}

	public function testAuthenticate(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Wrong identity
		$this->assertEquals('L\'adresse email et/ou le mot de passe semblent incorrects',$this->authenticationService->authenticate('LocalAuth','wrong','valid-credential'));

		//Wrong credential
		$this->assertEquals('L\'adresse email et/ou le mot de passe semblent incorrects',$this->authenticationService->authenticate('LocalAuth','valid','wrong-credential'));

		//Pending state
		$this->assertEquals('Le compte est en attente de confirmation',$this->authenticationService->authenticate('LocalAuth','pending','pending-credential'));

		//Unknown error
		$this->getServiceManager()->get('AccessControlAuthenticationService')->setAdapters(array(
			'FailAuth' => 'BoilerAppAccessControlTest\Authentication\Adapter\AuthenticationDoctrineAdapterFail'
		));
		$this->assertEquals('fail message',$this->authenticationService->authenticate('FailAuth',\Zend\Authentication\Result::FAILURE_UNCATEGORIZED,array('fail message')));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSendConfirmationResetCredentialWithWrongIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->authenticationService->sendConfirmationResetCredential(null);
	}

	/**
	 * @expectedException LogicException
	 */
	public function testResetCredentialWithUnknownEmailIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->authenticationService->resetCredential('wrong','wrong');
	}

	/**
	 * @expectedException LogicException
	 */
	public function testResetCredentialWithWrongPublicKey(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->authenticationService->resetCredential('wrong','valid@test.com');
	}

	/**
	 * @expectedException LogicException
	 */
	public function testResetCredentialWithPendingState(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->authenticationService->resetCredential('bc4b775da5e0d05ccbe5fa1c15','pending@test.com');
	}
}