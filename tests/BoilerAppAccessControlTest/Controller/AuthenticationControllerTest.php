<?php
namespace BoilerAppAccessControlTest\Controller;
class AuthenticationControllerTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractHttpControllerTestCase{
	public function testAuthenticateAction(){
		$this->createDatabase();
		$this->dispatch('/access-control/authenticate');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/Authenticate');
	}

	public function testAuthenticateActionPost(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->dispatch('/access-control/authenticate',\Zend\Http\Request::METHOD_POST,array(
			'auth_access_identity' => 'valid@test.com',
			'auth_access_credential' => 'valid-credential'
		));
		$this->assertRedirectTo('/');
	}

	public function testPendingAuthenticateActionPost(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->dispatch('/access-control/authenticate',\Zend\Http\Request::METHOD_POST,array(
			'auth_access_identity' => 'pending@test.com',
			'auth_access_credential' => 'pending-credential'
		));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/Authenticate');
	}

	public function testWrongAuthenticateActionPost(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->dispatch('/access-control/authenticate',\Zend\Http\Request::METHOD_POST,array(
			'auth_access_identity' => 'valid@test.com',
			'auth_access_credential' => 'wrong-credential'
		));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/Authenticate');
	}

	public function testForgottenCredentialAction(){
		$this->createDatabase();
		$this->dispatch('/access-control/forgotten-credential');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/ForgottenCredential');
	}

	public function testForgottenCredentialActionPost(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->dispatch('/access-control/forgotten-credential',\Zend\Http\Request::METHOD_POST,array(
			'auth_access_identity' => 'valid@test.com',
		));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\Authentication');
		$this->assertControllerClass('AuthenticationController');
		$this->assertMatchedRouteName('AccessControl/ForgottenCredential');
	}

	public function testPendingForgottenCredentialActionPost(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));
		$this->dispatch('/access-control/forgotten-credential',\Zend\Http\Request::METHOD_POST,array(
			'auth_access_identity' => 'pending@test.com',
		));
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
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate('LocalAuth','valid','valid-credential');
		$this->dispatch('/access-control/logout');
		$this->assertRedirectTo('/');
	}
}