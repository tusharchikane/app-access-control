<?php
namespace BoilerAppAccessControl\Validator;
class AuthAccessCredentialValidator extends \Zend\Validator\AbstractValidator{
	const INVALID = 'authAccessCredentialInvalid';
	const WRONG = 'authAccessCredentialWrong';

    /**
     * @var array
     */
    protected $messageTemplates = array(
    	self::INVALID => 'Invalid type given. String expected',
    	self::WRONG => 'The credential is wrong',
    );

    /**
     * @var \Zend\Crypt\Password\PasswordInterface
     */
    protected $encryptor;

    /**
     * @var string
     */
    protected $auth_access_credential;

    /**
     * @param \Zend\Crypt\Password\PasswordInterface $oEncryptor
     * @return \BoilerAppAccessControl\Validator\AuthAccessCredentialValidator
     */
    public function setEncryptor(\Zend\Crypt\Password\PasswordInterface $oEncryptor){
    	$this->encryptor = $oEncryptor;
    	return $this;
    }

    /**
     * @throws \LogicException
     * @return \Zend\Crypt\Password\PasswordInterface
     */
    public function getEncryptor(){
    	if($this->encryptor instanceof \Zend\Crypt\Password\PasswordInterface)return $this->encryptor;
    	throw new \LogicException('Encryptor is undefined');
    }

    /**
     * @param string $sAuthAccessCredential
     * @throws \InvalidArgumentException
     * @return \BoilerAppAccessControl\Validator\AuthAccessCredentialValidator
     */
    public function setAuthAccessCredential($sAuthAccessCredential){
    	if(empty($sAuthAccessCredential))throw new \InvalidArgumentException('AuthAccess credential is empty');
    	if(!is_string($sAuthAccessCredential))throw new \InvalidArgumentException('AuthAccess credential expects a string, "'.gettype($sAuthAccessCredential).'" given');
    	$this->auth_access_credential = $sAuthAccessCredential;
    	return $this;
    }

    /**
     * @throws \LogicException
     * @return string
     */
    public function getAuthAccessCredential(){
    	if(is_string($this->auth_access_credential))return $this->auth_access_credential;
    	throw new \LogicException('AuthAccess credential is undefined');
    }

    /**
     * Returns true if $sValue match with the defined AuthAccess credential
     * @param string $sValue
     * @return boolean
     */
    public function isValid($sValue){
    	if(empty($sValue)|| !is_string($sValue)){
    		$this->error(self::INVALID);
    		return false;
    	}

    	$this->setValue($sValue);

    	//Verify AuthAccess credential
    	if($this->getEncryptor()->verify(md5($sValue), $this->getAuthAccessCredential()))return true;

    	$this->error(self::WRONG,$sValue);
    	return false;
    }
}