<?php
namespace BoilerAppAccessControlTest\Controller;
class AuthenticationControllerTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractHttpControllerTestCase{
	public function testAuthenticateAction(){
		$this->dispatch('/access-control/authenticate');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/Authenticate');
	}

	public function testForgottenCredentialAction(){
		$this->dispatch('/access-control/forgotten-credential');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/ForgottenCredential');
	}

	public function testResetCredentialAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->dispatch('/access-control/reset-credential/bc4b775da5e0d05ccbe5fa1c14/valid%40test.com');

		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/ResetCredential');
	}

	public function testLogoutAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Log in
		$this->getApplicationServiceLocator()->get('AccessControlAuthenticationService')->authenticate('LocalAuth','valid','valid-credential');
		$this->dispatch('/access-control/logout');
		$this->assertRedirectTo('/access-control/authenticate');
	}
}