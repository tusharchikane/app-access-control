<?php
namespace BoilerAppAccessControl\Authentication;
class AccessControlAuthenticationService implements \Zend\ServiceManager\ServiceLocatorAwareInterface{
	use \Zend\ServiceManager\ServiceLocatorAwareTrait;

	const AUTH_RESULT_AUTH_ACCESS_STATE_PENDING = -1;
	const AUTH_RESULT_IDENTITY_WRONG = 0;
	const AUTH_RESULT_VALID = 1;

	/**
	 * @var \Zend\Authentication\AuthenticationService
	 */
	protected $authenticationService;

	/**
	 * @var array
	 */
	protected $adapters = array();

	/**
	 * @var \Zend\Authentication\Storage\StorageInterface
	 */
	protected $storage;

	/**
	 * Instantiate AccessControl Authentication Service
	 * @param array|Traversable $aConfiguration
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService
	 */
	public static function factory($aConfiguration,\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		if($aConfiguration instanceof \Traversable)$aConfiguration = \Zend\Stdlib\ArrayUtils::iteratorToArray($aConfiguration);
		elseif(!is_array($aConfiguration))throw new \InvalidArgumentException(__METHOD__.' expects an array or Traversable object; received "'.(is_object($aConfiguration)?get_class($aConfiguration):gettype($aConfiguration)).'"');

		$oUserAuthenticationService = new static($aConfiguration['storage'],isset($aConfiguration['adapters'])?$aConfiguration['adapters']:array());

		//Adapters
		if(isset($aConfiguration['adapters']))$oUserAuthenticationService->setAdapters($aConfiguration['adapters']);

		//Storage
		if(isset($aConfiguration['storage'])){
			if(!($aConfiguration['storage'] instanceof \Zend\Authentication\Storage\StorageInterface)){
				if(!is_string($aConfiguration['storage']))throw new \InvalidArgumentException(sprintf(
					'Storage configuration expects \Zend\Authentication\Storage\StorageInterface or string, "%s" given',
					is_object($aConfiguration['storage'])?get_class($aConfiguration['storage']):gettype($aConfiguration['storage'])
				));
				if($oServiceLocator->has($aConfiguration['storage']))$aConfiguration['storage'] = $oServiceLocator->get($aConfiguration['storage']);
				elseif(class_exists($aConfiguration['storage']))$aConfiguration['storage'] = new $aConfiguration['storage']();
				else throw new \InvalidArgumentException($aConfiguration['storage'].' is not an available service or an existing class');
			}
			$oUserAuthenticationService->setStorage($aConfiguration['storage']);
		}

		return $oUserAuthenticationService->setServiceLocator($oServiceLocator);
	}

	/**
	 * @param array $aAdapters
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService
	 */
	public function setAdapters(array $aAdapters){
		if(empty($aAdapters))throw new \InvalidArgumentException('setAdapters expects not empty array');
		foreach($aAdapters as $sAdapterName => $oAdapter){
			if(is_array($sAdapterName)){
				if(!empty($oAdapter['name']))$sAdapterName = $oAdapter['name'];
				if(isset($oAdapter['adapter']))$oAdapter = $oAdapter['adapter'];
			}
			$this->setAdapter($sAdapterName, $oAdapter);
		}
		return $this;
	}

	/**
	 * @param string $sAdapterName
	 * @param string|\BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface $oAdapter
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService
	 */
	protected function setAdapter($sAdapterName, $oAdapter){
		if(!is_string($sAdapterName))throw new \InvalidArgumentException('Adapter\'s name expects string, "'.gettype($sAdapterName).'" given');
		if($oAdapter instanceof \BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface)$this->adapters[$sAdapterName] = $oAdapter;
		elseif(is_string($oAdapter))$this->adapters[$sAdapterName] = $oAdapter;
		else throw new \InvalidArgumentException(sprintf(
			'Adapter expects \BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface or string, "%s" given',
			is_object($oAdapter)?get_class($oAdapter):gettype($oAdapter)
		));
		return $this;
	}

	/**
	 * @param string $sAdapterName
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface
	 */
	public function getAdapter($sAdapterName){
		if(!is_string($sAdapterName))throw new \InvalidArgumentException('Adapter\'s name expects string, "'.gettype($sAdapterName).'" given');
		if(!isset($this->adapters[$sAdapterName]))throw new \InvalidArgumentException('Adapter "'.$sAdapterName.'" is undefined');
		if(!($this->adapters[$sAdapterName] instanceof \BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface)){
			if(!is_string($this->adapters[$sAdapterName]))throw new \InvalidArgumentException(sprintf(
				'Adapter "%s" expects \BoilerAppAccessControl\Authentication\Adapter\AuthenticationAdapterInterface or string, "%s" given',
				$sAdapterName,is_object($this->adapters[$sAdapterName])?get_class($this->adapters[$sAdapterName]):gettype($sAdapterName)
			));
			if($this->getServiceLocator()->has($this->adapters[$sAdapterName]))$this->adapters[$sAdapterName] = $this->getServiceLocator()->get($this->adapters[$sAdapterName]);
			elseif(class_exists($this->adapters[$sAdapterName]))$this->adapters[$sAdapterName] = new $this->adapters[$sAdapterName]();
			else throw new \InvalidArgumentException($this->adapters[$sAdapterName].' is not an available service or an existing class');
		}
		return $this->adapters[$sAdapterName];
	}

	/**
	 * @param \Zend\Authentication\Storage\StorageInterface $oStorage
	 * @return \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService
	 */
	public function setStorage(\Zend\Authentication\Storage\StorageInterface $oStorage){
		$this->storage = $oStorage;
		return $this;
	}

	/**
	 * @return \Zend\Authentication\AuthenticationService
	 */
	public function getAuthenticationService(){
		return $this->authenticationService instanceof \Zend\Authentication\AuthenticationService
			?$this->authenticationService
			:$this->authenticationService = new \Zend\Authentication\AuthenticationService($this->storage);
	}

	/**
	 * @param string $sAdapterName
	 * @throws \InvalidArgumentException
	 * @throws \DomainException
	 * @throws \LogicException
	 * @return string
	 */
	public function authenticate($sAdapterName){
		if(!is_string($sAdapterName))throw new \InvalidArgumentException('Adapter\'s name expects string, '.gettype($sAdapterName));

		//Performs adapter initialization
		$oAdapter = $this->getAdapter($sAdapterName);
		if(is_callable(array($oAdapter,'postAuthenticate')))call_user_func_array(
			array($this->getAdapter($sAdapterName),'postAuthenticate'),
			array_slice(func_get_args(),1)
		);

		$oAuthResult = $this->getAuthenticationService()->authenticate($oAdapter);
		if($oAuthResult->isValid()){
			$aAuthAccessInfos = $oAdapter->getResultRowObject(array('auth_access_id','auth_access_state'));
			$iAuthAccessId = $aAuthAccessInfos->auth_access_id;
			$sAuthAccessState = $aAuthAccessInfos->auth_access_state;
		}
		else switch($oAuthResult->getCode()){
			case \Zend\Authentication\Result::FAILURE_IDENTITY_NOT_FOUND:
			case \Zend\Authentication\Result::FAILURE_IDENTITY_AMBIGUOUS:
			case \Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID:
				return self::AUTH_RESULT_IDENTITY_WRONG;
			case \Zend\Authentication\Result::FAILURE_UNCATEGORIZED:
			case \Zend\Authentication\Result::FAILURE:
				if($aMessages = $oAuthResult->getMessages()){
					$sReturn = '';
					$oTranslator = $this->getServiceLocator('translator');
					foreach($aMessages as $sMessage){
						if($sReturn)$sReturn .= ', ';
						$sReturn .= $oTranslator->translate($sMessage);
					}
					return $sReturn;
				}
			default:
				throw new \DomainException('Unknown result failure code : '.$oAuthResult->getCode());
		}

		//Authentication is valid, check user state
		if(!isset($iAuthAccessId,$sAuthAccessState))throw new \LogicException('Auth access id or auth access state are undefined');

		if($sAuthAccessState === \BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_ACTIVE_STATE){
			//Store user id
			$this->getAuthenticationService()->getStorage()->write($iAuthAccessId);
			return self::AUTH_RESULT_VALID;
		}
		else return self::AUTH_RESULT_AUTH_ACCESS_STATE_PENDING;
	}

	/**
	 * @return boolean
	 */
	public function hasIdentity(){
		return $this->getAuthenticationService()->hasIdentity();
	}

	/**
	 * @throws \LogicException
	 * @return mixed
	 */
	public function getIdentity(){
		if($this->hasIdentity())return $this->getAuthenticationService()->getIdentity();
		throw new \LogicException('There is no stored identity');
	}

	/**
	 * @throws \LogicException
	 * @return \User\Authentication\UserAuthenticationService
	 */
	public function clearIdentity(){
		if(!$this->hasIdentity())throw new \LogicException('There is no stored identity');
		//Clear auth storage
		$this->getAuthenticationService()->clearIdentity();

		//Clear adapter storage
		$oAdapter = $this->getAuthenticationService()->getAdapter();
		if(is_callable(array($oAdapter,'clearIdentity')))$oAdapter->clearIdentity();
		return $this;
	}
}