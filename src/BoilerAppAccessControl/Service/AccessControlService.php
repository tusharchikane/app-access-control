<?php
namespace BoilerAppAccessControl\Service;
class AccessControlService implements \Zend\ServiceManager\ServiceLocatorAwareInterface{
	use \Zend\ServiceManager\ServiceLocatorAwareTrait;

	/**
	 * @throws \RuntimeException
	 * @throws \LogicException
	 * @return \BoilerAppAccessControl\Entity\AuthAccessEntity
	 */
	public function getAuthenticatedAuthAccess(){
		$iAuthAccessId = $this->getServiceLocator()->get('AccessControlAuthenticationService')->getIdentity();

		//Prevent from session value error
		try{
			$oAuthAccess = $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->find($iAuthAccessId);
			if(!($oAuthAccess instanceof \BoilerAppAccessControl\Entity\AuthAccessEntity))throw new \LogicException('Auth access id "'.$iAuthAccessId.'" is unknown');
		}
		catch(\Exception $oException){
			$this->getServiceLocator()->get('AuthenticationService')->logout();
			throw new \RuntimeException('An error occurred when retrieving authenticated AuthAccess',$oException->getCode(),$oException);
		}

		if($oAuthAccess->getAuthAccessState() !== \BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_ACTIVE_STATE){
			//Log out
			$this->getServiceLocator()->get('AccessControlAuthenticationService')->clearIdentity();
			throw new \LogicException(sprintf('AuthAccess "%s"  is not active',
				$oAuthAccess->getAuthAccessId()
			));
		}


		return $oAuthAccess;
	}

	/**
	 * @param string $sAuthAccessIdentity
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Entity\AuthAccessEntity|NULL
	 */
	public function getAuthAccessFromIdentity($sAuthAccessIdentity){
		if(empty($sAuthAccessIdentity) || !is_string($sAuthAccessIdentity))throw new \InvalidArgumentException(sprintf(
			'AuthAccess identity expects a not empty string, "%s" given',
			is_scalar($sAuthAccessIdentity)?$sAuthAccessIdentity:gettype($sAuthAccessIdentity)
		));

		$oAuthAccessRepository = $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository');

		//Try retrieving existing AuthAccess for the giving identities
		$aAvailableIdentities = $oAuthAccessRepository->getAvailableIdentities();
		$oAuthAccess = null;
		while(!$oAuthAccess && $aAvailableIdentities){
			$sIdentityName = array_shift($aAvailableIdentities);
			if($sIdentityName === 'auth_access_email_identity' && !filter_var($sAuthAccessIdentity,FILTER_VALIDATE_EMAIL))continue;
			$oAuthAccess = $oAuthAccessRepository->findOneBy(array($sIdentityName => $sAuthAccessIdentity));
		}
		return $oAuthAccess;
	}

	/**
	 * @param string $sEmailIdentity
	 * @throws \InvalidArgumentException
	 * @return boolean|string
	 */
	public function isEmailIdentityAvailable($sEmailIdentity){
		if(empty($sEmailIdentity) || !is_string($sEmailIdentity))throw new \InvalidArgumentException('Email expects string, "'.(empty($sEmailIdentity)?'':gettype($sEmailIdentity)).'" given');

		$oTranslator = $this->getServiceLocator()->get('translator');

		//If request is from logged user
		if($this->getServiceLocator()->get('AccessControlAuthenticationService')->hasIdentity() && $this->getAuthenticatedAuthAccess()->getAuthAccessEmailIdentity() === $sEmailIdentity)return str_ireplace(
			array('%identityName%','%value%'),array($oTranslator->translate('the_email'),$sEmailIdentity),
			$oTranslator->translate('The %identityName% "%value%" is the same as currently used','validator')
		);

		return $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->isIdentityEmailAvailable($sEmailIdentity)?true:str_ireplace(
			array('%identityName%','%value%'),array($oTranslator->translate('the_email'),$sEmailIdentity),
			$oTranslator->translate('The %identityName% "%value%" is unavailable','validator')
		);
	}

	/**
	 * @param string $sUsernameIdentity
	 * @throws \InvalidArgumentException
	 * @return boolean|string
	 */
	public function isUsernameIdentityAvailable($sUsernameIdentity){
		if(empty($sUsernameIdentity) || !is_string($sUsernameIdentity))throw new \InvalidArgumentException('Username identity expects string, "'.(empty($sUsernameIdentity)?'':gettype($sUsernameIdentity)).'" given');

		$oTranslator = $this->getServiceLocator()->get('translator');

		//If request is from logged user
		if($this->getServiceLocator()->get('AccessControlAuthenticationService')->hasIdentity() && $this->getAuthenticatedAuthAccess()->getAuthAccessUsernameIdentity() === $sUsernameIdentity)return str_ireplace(
			array('%identityName%','%value%'),array($oTranslator->translate('the_username'),$sUsernameIdentity),
			$oTranslator->translate('The %identityName% "%value%" is the same as currently used','validator')
		);

		return $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->isIdentityUserNameAvailable($sUsernameIdentity)?true:str_ireplace(
			array('%identityName%','%value%'),array($oTranslator->translate('the_username'),$sUsernameIdentity),
			$oTranslator->translate('The %identityName% "%value%" is unavailable','validator')
		);
	}

	/**
	 * Generate a random public key
	 * @return string
	 */
	public function generateAuthAccessPublicKey(){
		return str_ireplace('.', '', str_shuffle(uniqid(str_shuffle(uniqid()))));
	}
}