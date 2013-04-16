<?php
namespace BoilerAppAccessControlTest\Authentication\Adapter;
class AuthenticationDoctrineAdapterTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase{

	/**
	 * @var \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter
	 */
	protected $authenticationDoctrineAdapter;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase
	 */
	protected function setUp(){
		parent::setUp();
		$oAuthenticationDoctrineAdapterFactory = new \BoilerAppAccessControl\Factory\AuthenticationDoctrineAdapterFactory();
		$this->authenticationDoctrineAdapter = $oAuthenticationDoctrineAdapterFactory->createService($this->getServiceManager());
	}

	public function testGetAccessControlService(){
		$this->assertInstanceOf('\BoilerAppAccessControl\Service\AccessControlService', $this->authenticationDoctrineAdapter->getAccessControlService());
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetAccessControlServiceUnset(){
		$oReflectionClass = new \ReflectionClass('BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter');
		$oAccessControlService = $oReflectionClass->getProperty('accessControlService');
		$oAccessControlService->setAccessible(true);
		$oAccessControlService->setValue($this->authenticationDoctrineAdapter, null);
		$this->authenticationDoctrineAdapter->getAccessControlService();
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPostAuthenticateWithWrongParams(){
		$this->authenticationDoctrineAdapter->postAuthenticate(false, false);
	}

	public function testAuthenticate(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Identity not found
		$this->assertInstanceOf(
			'\BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter',
			$this->authenticationDoctrineAdapter->postAuthenticate('wrong','valid-credential')
		);
		$this->assertInstanceOf('\Zend\Authentication\Result', $oResult = $this->authenticationDoctrineAdapter->authenticate());
		$this->assertEquals(\Zend\Authentication\Result::FAILURE_IDENTITY_NOT_FOUND,$oResult->getCode());

		//Credential invalid
		$this->assertInstanceOf(
			'\BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter',
			$this->authenticationDoctrineAdapter->postAuthenticate('valid','wrong-credential')
		);
		$this->assertInstanceOf('\Zend\Authentication\Result', $oResult = $this->authenticationDoctrineAdapter->authenticate());
		$this->assertEquals(\Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID,$oResult->getCode());

		//Success
		$this->assertInstanceOf(
			'\BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter',
			$this->authenticationDoctrineAdapter->postAuthenticate('valid','valid-credential')
		);
		$this->assertInstanceOf('\Zend\Authentication\Result', $oResult = $this->authenticationDoctrineAdapter->authenticate());
		$this->assertEquals(\Zend\Authentication\Result::SUCCESS,$oResult->getCode());
	}

	public function testGetResultRowObject(){
		//Add authentication fixture
		$this->addFixtures(array('BoilerAppAccessControlTest\Fixture\AuthenticationFixture'));

		//Authentication succeed
		$this->authenticationDoctrineAdapter->postAuthenticate('valid','valid-credential')->authenticate();
		$oResultRow = $this->authenticationDoctrineAdapter->getResultRowObject();
		$this->assertObjectHasAttribute('auth_access_id', $oResultRow);
		$this->assertObjectHasAttribute('auth_access_state', $oResultRow);

		$oResultRow = $this->authenticationDoctrineAdapter->getResultRowObject(array('auth_access_id'));
		$this->assertObjectHasAttribute('auth_access_id', $oResultRow);
		$this->assertObjectNotHasAttribute('auth_access_state', $oResultRow);

		$oResultRow = $this->authenticationDoctrineAdapter->getResultRowObject(null,array('auth_access_id'));
		$this->assertObjectNotHasAttribute('auth_access_id', $oResultRow);
		$this->assertObjectHasAttribute('auth_access_state', $oResultRow);

		//Authentication failed
		$this->authenticationDoctrineAdapter->postAuthenticate('wrong','valid-credential')->authenticate();
		$this->assertFalse($this->authenticationDoctrineAdapter->getResultRowObject());
	}
}