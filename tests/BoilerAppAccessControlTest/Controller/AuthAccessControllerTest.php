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
	}

	public function testConfirmChangeEmailIdentityAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->dispatch('/access-control/auth-access/confirm-change-email-identity/bc4b775da5e0d05ccbe5fa1c14/new@test.com');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess/ConfirmChangeEmailIdentity');

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

		//Verify credential
		$this->assertTrue($this->getApplicationServiceLocator()->get('Encryptor')->verify(
			md5('new-credential'),
			$this->getServiceManager()->get('AccessControlService')->getAuthenticatedAuthAccess()->getAuthAccessCredential()
		));
	}

	public function testRemoveAuthAccessActionAction(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->getRequest()->getHeaders()->addHeaderLine('X_REQUESTED_WITH', 'XMLHttpRequest');

		$this->dispatch('/access-control/auth-access/remove-auth-access');
		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess/RemoveAuthAccess');
	}

	public function testRemoveAuthAccessActionPost(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authenticate user
		$this->getApplicationServiceLocator()->get('AuthenticationService')->authenticate(
			\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
			'valid@test.com',
			'valid-credential'
		);

		$this->getRequest()->getHeaders()->addHeaderLine('X_REQUESTED_WITH', 'XMLHttpRequest');

		$this->dispatch('/access-control/auth-access/remove-auth-access',\Zend\Http\Request::METHOD_POST,array(
			'auth_access_credential' => 'valid-credential',
		));

		$this->assertResponseStatusCode(200);
		$this->assertModuleName('BoilerAppAccessControl');
		$this->assertControllerName('BoilerAppAccessControl\Controller\AuthAccess');
		$this->assertControllerClass('AuthAccessController');
		$this->assertMatchedRouteName('AccessControl/AuthAccess/RemoveAuthAccess');

		//Check that AuthAccess has been logged out
		$this->assertFalse($this->getApplicationServiceLocator()->get('AccessControlAuthenticationService')->hasIdentity());
	}
}