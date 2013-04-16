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
		$this->getRequest()->getHeaders()->addHeader(\Zend\Http\Header\Accept::fromString('Accept: application/json; version=0.2'));


		$this->dispatch('/access-control/check-email-identity-availability',\Zend\Http\Request::METHOD_POST,array('email_identity' => 'available@test.com'));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Registration');
		$this->assertControllerClass('RegistrationController');
		$this->assertMatchedRouteName('AccessControl/CheckEmailIdentityAvailability');
	}

	public function testCheckUsernameIdentityAvailabilityAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->getRequest()->getHeaders()->addHeader(\Zend\Http\Header\Accept::fromString('Accept: application/json; version=0.2'));

		$this->dispatch('/access-control/check-username-identity-availability',\Zend\Http\Request::METHOD_POST,array('username_identity' => 'available'));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Registration');
		$this->assertControllerClass('RegistrationController');
		$this->assertMatchedRouteName('AccessControl/CheckUsernameIdentityAvailability');
	}

	public function testConfirmEmailAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		$this->dispatch('/access-control/confirm-email/'.urldecode('bc4b775da5e0d05ccbe5fa1c15').'/'.urldecode('pending@test.com'));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Registration');
		$this->assertControllerClass('RegistrationController');
		$this->assertMatchedRouteName('AccessControl/ConfirmEmail');
	}

	public function testResendConfirmationEmailAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->getRequest()->getHeaders()->addHeader(\Zend\Http\Header\Accept::fromString('Accept: application/json; version=0.2'));

		$this->dispatch('/access-control/resend-confirmation-email',\Zend\Http\Request::METHOD_POST,array('auth_access_identity' => 'pending'));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Registration');
		$this->assertControllerClass('RegistrationController');
		$this->assertMatchedRouteName('AccessControl/ResendConfirmationEmail');
	}
}