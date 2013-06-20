<?php
namespace BoilerAppAccessControlTest\Validator;
class AuthAccessCredentialValidatorTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase{

	/**
	 * @var \BoilerAppAccessControl\Validator\AuthAccessCredentialValidator
	 */
	protected $authAccessCredentialValidator;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
		$this->authAccessCredentialValidator = new \BoilerAppAccessControl\Validator\AuthAccessCredentialValidator();
	}

	/**
	 * @expectedException \LogicException
	 */
    public function testGetAuthAccessCredentialUndefined(){
    	$this->authAccessCredentialValidator->getAuthAccessCredential();
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetEncryptorUndefined(){
    	$this->authAccessCredentialValidator->getEncryptor();
    }

    public function testIsValid(){
    	$this->authAccessCredentialValidator
    		->setEncryptor($oEncryptor = $this->getServiceManager()->get('Encryptor'))
    		->setAuthAccessCredential($oEncryptor->create(md5('valid-credential')));

    	//Not string value
    	$this->assertFalse($this->authAccessCredentialValidator->isValid(array('false')));

		//Wrong credential
    	$this->assertFalse($this->authAccessCredentialValidator->isValid('wrong'));

    	//Valid
    	$this->assertTrue($this->authAccessCredentialValidator->isValid('valid-credential'));
    }
}