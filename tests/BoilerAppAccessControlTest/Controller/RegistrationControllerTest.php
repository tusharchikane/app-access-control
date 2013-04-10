<?php
namespace BoilerAppAccessControlTest\Controller;
class RegistrationControllerTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractHttpControllerTestCase{

	public function testRegisterAction(){
		$this->dispatch('/access-control/register');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Registration');
		$this->assertControllerClass('RegistrationController');
		$this->assertMatchedRouteName('AccessControl/Register');
	}

	public function testCheckEmailIdentityAvailabilityAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->dispatch('/access-control/check-email-identity-availability',\Zend\Http\Request::METHOD_POST,array('email' => 'available@test.com'));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Registration');
		$this->assertControllerClass('RegistrationController');
		$this->assertMatchedRouteName('AccessControl/CheckEmailIdentityAvailability');
	}

	/*public function testCheckUsernameIdentityAvailabilityAction(){
		$this->dispatch('/access-control/check-username-identity-availability');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Registration');
		$this->assertControllerClass('RegistrationController');
		$this->assertMatchedRouteName('AccessControl/CheckUsernameIdentityAvailability');
	}

	public function testConfirmEmailAction(){
		$this->dispatch('/access-control/confirm-email/bc4b775da5e0d05ccbe5fa1c14/pending%40test.com');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Registration');
		$this->assertControllerClass('RegistrationController');
		$this->assertMatchedRouteName('AccessControl/ConfirmEmail');
	}

	public function testResendConfirmationEmailAction(){
		$this->dispatch('/access-control/resend-confirmation-email');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Registration');
		$this->assertControllerClass('RegistrationController');
		$this->assertMatchedRouteName('AccessControl/ResendConfirmationEmail');
	}*/
}