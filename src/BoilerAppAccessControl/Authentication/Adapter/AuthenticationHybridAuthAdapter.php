<?php
namespace BoilerAppAccessControl\Authentication\Adapter;
class AuthenticationHybridAuthAdapter implements \BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface{
	const AUTH_RESULT_HYBRID_AUTH_USER_NOT_CONNECTED = '';
	const AUTH_RESULT_HYBRID_AUTH_CANCELED = '';

	/**
	 * @var \User\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @var \BoilerAppAccessControl\Repository\AuthProviderRepository
	 */
	protected $authProviderRepository;

	/**
	 * @var \Hybrid_Auth
	 */
	protected $hybridAuth;

	/**
	 * @var string
	 */
	protected $currentService;

	/**
	 * @var array
	 */
	protected $resultRow;

	/**
	 * Constructor
	 * @param \User\Repository\UserRepository $oUserRepository
	 * @param \BoilerAppAccessControl\Repository\AuthProviderRepository $oAuthProviderRepository
	 * @param \Hybrid_Auth $oHybridAuth
	 */
	public function __construct(
		\User\Repository\UserRepository $oUserRepository = null,
		\BoilerAppAccessControl\Repository\AuthProviderRepository $oAuthProviderRepository = null,
		\Hybrid_Auth $oHybridAuth = null
	){
		if($oUserRepository)$this->setUserRepository($oUserRepository);
		if($oAuthProviderRepository)$this->setAuthProviderRepository($oAuthProviderRepository);
		if($oHybridAuth)$this->setHybridAuth($oHybridAuth);
	}

	/**
	 * @param \User\Repository\UserRepository $oRepository
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter
	 */
	public function setUserRepository(\User\Repository\UserRepository $oRepository){
		$this->userRepository = $oRepository;
		return $this;
	}

	/**
	 * @throws \LogicException
	 * @return \User\Repository\UserRepository
	 */
	public function getUserRepository(){
		if(!($this->userRepository instanceof \User\Repository\UserRepository))throw new \LogicException('User repository is undefined');
		return $this->userRepository;
	}

	/**
	 * @param \BoilerAppAccessControl\Repository\AuthProviderRepository $oRepository
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter
	 */
	public function setAuthProviderRepository(\BoilerAppAccessControl\Repository\AuthProviderRepository $oRepository){
		$this->authProviderRepository = $oRepository;
		return $this;
	}

	/**
	 * @throws \LogicException
	 * @return \BoilerAppAccessControl\Repository\AuthProviderRepository
	 */
	public function getAuthProviderRepository(){
		if(!($this->authProviderRepository instanceof \BoilerAppAccessControl\Repository\AuthProviderRepository))throw new \LogicException('AuthProvider repository is undefined');
		return $this->authProviderRepository;
	}

	/**
	 * @param \Hybrid_Auth $oHybridAuth
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationHybridAuthAdapter
	 */
	public function setHybridAuth(\Hybrid_Auth $oHybridAuth){
		$this->hybridAuth = $oHybridAuth;
		return $this;
	}

	/**
	 * @throws \Exception
	 * @return \Hybrid_Auth
	 */
	public function getHybridAuth(){
		if($this->hybridAuth instanceof \Hybrid_Auth)return $this->hybridAuth;
		throw new \Exception('HybridAuth is undefined');
	}

	/**
	 * @param string $sCurrentService
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationHybridAuthAdapter
	 */
	public function setCurrentService($sCurrentService){
		if(!is_string($sCurrentService))throw new \InvalidArgumentException('Service expects string, "'.gettype($sCurrentService).'" given');
		$this->currentService = $sCurrentService;
		return $this;
	}

	/**
	 * @throws \LogicException
	 * @return string
	 */
	public function getCurrentService(){
		if(!is_string($this->currentService))throw new \LogicException('Service is undefined');
		return $this->currentService;
	}

	/**
	 * @param string $sCurrentService
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationHybridAuthAdapter
	 */
	public function postAuthenticate($sCurrentService){
		if($sCurrentService)$this->setCurrentService($sCurrentService);
		return $this;
	}

	/**
	 * @see Hybrid_Auth::authenticate()
	 * @throws \UnexpectedValueException
	 * @return \Zend\Authentication\Result
	 */
	public function authenticate(){
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
		elseif(null !== $aOmitColumns){
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

	/**
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationHybridAuthAdapter
	 */
	public function clearIdentity(){
		$this->logoutAllProviders();
		return $this;
	}
}