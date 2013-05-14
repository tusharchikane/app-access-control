<?php
namespace BoilerAppAccessControlTest\Controller;
class AuthAccessControllerTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractHttpControllerTestCase{

	public function testIndexAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->dispatch('/access-control/auth-access');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess');
	}

	public function testChangeEmailIdentityAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->getRequest()->getHeaders()->addHeaderLine('X_REQUESTED_WITH', 'XMLHttpRequest');

		$this->dispatch('/access-control/auth-access/change-email-identity');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess/ChangeEmailIdentity');
	}

	public function testChangeEmailIdentityActionPost(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->getRequest()->getHeaders()->addHeaderLine('X_REQUESTED_WITH', 'XMLHttpRequest');

		$this->dispatch('/access-control/auth-access/change-email-identity',\Zend\Http\Request::METHOD_POST,array(
			'new_auth_access_email_identity' => 'new@test.com'
		));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess/ChangeEmailIdentity');

		$this->assertEquals('new@test.com',$this->getServiceManager()->get('AccessControlService')->getAuthenticatedAuthAccess()->getAuthAccessEmailIdentity());
	}

	public function testChangeUsernameIdentityAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->getRequest()->getHeaders()->addHeaderLine('X_REQUESTED_WITH', 'XMLHttpRequest');

		$this->dispatch('/access-control/auth-access/change-username-identity');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess/ChangeUsernameIdentity');
	}

	public function testChangeUsernameIdentityActionPost(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->getRequest()->getHeaders()->addHeaderLine('X_REQUESTED_WITH', 'XMLHttpRequest');

		$this->dispatch('/access-control/auth-access/change-username-identity',\Zend\Http\Request::METHOD_POST,array(
			'new_auth_access_username_identity' => 'new'
		));
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess/ChangeUsernameIdentity');

		$this->assertEquals('new',$this->getServiceManager()->get('AccessControlService')->getAuthenticatedAuthAccess()->getAuthAccessUsernameIdentity());
	}

	public function testChangeCredentialAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->getRequest()->getHeaders()->addHeaderLine('X_REQUESTED_WITH', 'XMLHttpRequest');

		$this->dispatch('/access-control/auth-access/change-credential');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess/ChangeCredential');
	}

	public function testChangeCredentialActionPost(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->getRequest()->getHeaders()->addHeaderLine('X_REQUESTED_WITH', 'XMLHttpRequest');

		$this->dispatch('/access-control/auth-access/change-credential',\Zend\Http\Request::METHOD_POST,array(
			'new_auth_access_credential' => 'new-credential',
			'auth_access_credential_confirm' => 'new-credential'
		));

		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess/ChangeCredential');

		$oBCrypt = new \Zend\Crypt\Password\Bcrypt();
		$this->assertTrue($oBCrypt->verify(
			md5('new-credential'),
			$this->getServiceManager()->get('AccessControlService')->getAuthenticatedAuthAccess()->getAuthAccessCredential()
		));
	}
}