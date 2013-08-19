<?php
namespace BoilerAppAccessControl\Authentication\Adapter;
class AuthenticationDoctrineAdapter extends \Zend\Authentication\Adapter\AbstractAdapter implements \BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface{

	/**
	 * @var \BoilerAppAccessControl\Service\AccessControlService
	 */
	protected $accessControlService;

	/**
	 * @var \Zend\Crypt\Password\PasswordInterface
	 */
	protected $encryptor;

	/**
	 * @var array
	 */
	protected $resultRow;

	/**
	 * @var null|int
	 */
	protected $mustRememberMe;

	/**
	 * Constructor
	 * @param \BoilerAppAccessControl\Service\AccessControlService $oAccessControlService
	 * @param \Zend\Crypt\Password\PasswordInterface $oEncryptor
	 */
	public function __construct(\BoilerAppAccessControl\Service\AccessControlService $oAccessControlService = null, \Zend\Crypt\Password\PasswordInterface $oEncryptor = null){
		if($oAccessControlService)$this->setAccessControlService($oAccessControlService);
		if($oEncryptor)$this->setEncryptor($oEncryptor);
	}

	/**
	 * @param \BoilerAppAccessControl\Service\AccessControlService $oAccessControlService
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter
	 */
	public function setAccessControlService(\BoilerAppAccessControl\Service\AccessControlService $oAccessControlService){
		$this->accessControlService = $oAccessControlService;
		return $this;
	}

	/**
	 * @throws \LogicException
	 * @return \BoilerAppAccessControl\Service\AccessControlService
	 */
	public function getAccessControlService(){
		if($this->accessControlService instanceof \BoilerAppAccessControl\Service\AccessControlService)return $this->accessControlService;
		throw new \LogicException('AccessControl service is undefined');
	}

	/**
	 * @param \Zend\Crypt\Password\PasswordInterface $oEncryptor
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter
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
	 * @param boolean $bMustRememberMe
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter
	 */
	public function setMustRememberMe($bMustRememberMe){
		if(is_bool($bMustRememberMe)){
			$this->mustRememberMe = $bMustRememberMe;
			return $this;
		}
		throw new \InvalidArgumentException('"Must Remember me" expects boolean, "'.gettype($bMustRememberMe).'" given');
	}

	/**
	 * @see \BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface::mustRememberMe()
	 * @throws \LogicException
	 * @return boolean
	 */
	public function mustRememberMe(){
		if(is_bool($this->mustRememberMe))return $this->mustRememberMe;
		throw new \LogicException('"Must Remember me" is undefined');
	}

	/**
	 * @param string $sIdentity
	 * @param string $sCredential
     * @param boolean $bMustRememberMe
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter
	 */
	public function postAuthenticate($sIdentity,$sCredential,$bMustRememberMe){
		if(!is_string($sIdentity))throw new \InvalidArgumentException('Identity expects string, "'.gettype($sIdentity).'" given');
		if(!is_string($sCredential))throw new \InvalidArgumentException('Credential expects string, "'.gettype($sCredential).'" given');
		return $this->setIdentity($sIdentity)->setCredential($sCredential)->setMustRememberMe($bMustRememberMe);
	}

	/**
	 * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
	 * @return \Zend\Authentication\Result
	 */
	public function authenticate(){
		//Reset previous identity datas
		$this->resultRow = null;

		//Retrieve AuthAccess from provided identity
		if(!($oAuthAccess = $this->getAccessControlService()->getAuthAccessFromIdentity($this->getIdentity())))return new \Zend\Authentication\Result(\Zend\Authentication\Result::FAILURE_IDENTITY_NOT_FOUND,null);

		//Verify credential
		if(!$this->getEncryptor()->verify(
			md5($this->getCredential()),
			$oAuthAccess->getAuthAccessCredential()
		))return new \Zend\Authentication\Result(\Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID,null);

		$this->resultRow = array(
			'auth_access_id' => $oAuthAccess->getAuthAccessId(),
			'auth_access_state' => $oAuthAccess->getAuthAccessState()
		);
		return new \Zend\Authentication\Result(\Zend\Authentication\Result::SUCCESS,$this->resultRow['auth_access_id']);
	}

	/**
	 * Returns the result row as a stdClass object
	 * @param string|array $aReturnColumns
	 * @param string|array $aOmitColumns
	 * @return stdClass|boolean
	 */
	public function getResultRowObject($aReturnColumns = null, $aOmitColumns = null){
		if(!$this->resultRow)return false;
		$oReturnObject = new \stdClass();

		if(null !== $aReturnColumns){
			$aAvailableColumns = array_keys($this->resultRow);
			foreach((array) $aReturnColumns as $sReturnColumn){
				if(in_array($sReturnColumn, $aAvailableColumns))$oReturnObject->{$sReturnColumn} = $this->resultRow[$sReturnColumn];
			}
			return $oReturnObject;
		}

		if(null !== $aOmitColumns){
			$aOmitColumns = (array)$aOmitColumns;
			foreach ($this->resultRow as $sResultColumn => $sResultValue) {
				if(!in_array($sResultColumn, $aOmitColumns))$oReturnObject->{$sResultColumn} = $sResultValue;
			}
			return $oReturnObject;
		}

		foreach($this->resultRow as $sResultColumn => $sResultValue){
			$oReturnObject->{$sResultColumn} = $sResultValue;
		}
		return $oReturnObject;
	}
}