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

	public function testHybridauthAction(){
		//Set $_SERVER params
		$this->dispatch('/access-control/hybridauth');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/Hybridauth');
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
		$this->dispatch('/access-control/reset-credential');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/ResetCredential');
	}

	public function testLogoutAction(){
		$this->dispatch('/access-control/logout');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/Logout');
	}
}