<?php
namespace BoilerAppAccessControlTest\Service;
class RegistrationServiceTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase{

	/**
	 * @var \BoilerAppAccessControl\Service\RegistrationService
	 */
	protected $registrationService;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
		$this->registrationService = new \BoilerAppAccessControl\Service\RegistrationService();
		$this->registrationService->setServiceLocator($this->getServiceManager());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testRegisterWithSpacedUsername(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->registrationService->register(array(
			'auth_access_email_identity' => '',
			'auth_access_username_identity' => '  ',
			'auth_access_credential' => ''
		));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testRegisterWithWrongEmail(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->registrationService->register(array(
			'auth_access_email_identity' => 'wrong',
			'auth_access_username_identity' => 'test',
			'auth_access_credential' => ''
		));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testRegisterWithWrongCredential(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->registrationService->register(array(
			'auth_access_email_identity' => 'test@test.com',
			'auth_access_username_identity' => 'test',
			'auth_access_credential' => false
		));
	}

	/**
	 * @expectedException LogicException
	 */
	public function testConfirmEmailWithUnknownEmailIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->registrationService->confirmEmail('wrong','wrong');
	}

	/**
	 * @expectedException LogicException
	 */
	public function testConfirmEmailWithWrongPublicKey(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->registrationService->confirmEmail('wrong','valid@test.com');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testResendConfirmationEmailWithWrongIdentity(){
		$this->registrationService->resendConfirmationEmail(null);
	}

	/**
	 * @expectedException LogicException
	 */
	public function testResendConfirmationEmailWithUnknownIdentity(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->registrationService->resendConfirmationEmail('wrong');
	}
}