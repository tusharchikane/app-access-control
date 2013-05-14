<?php
namespace BoilerAppAccessControl\Service;
class AuthAccessService implements \Zend\ServiceManager\ServiceLocatorAwareInterface{
	use \Zend\ServiceManager\ServiceLocatorAwareTrait;

	/**
	 * Change current authenticated AuthAccess email identity if available
	 * @param string $sAuthAccessEmailIdentity
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Service\AuthAccessService
	 */
	public function changeAuthenticatedAuthAccessEmailIdentity($sAuthAccessEmailIdentity){
		if(!is_string($sAuthAccessEmailIdentity))throw new \InvalidArgumentException('AuthAccess email identity expects string, "'.gettype($sAuthAccessEmailIdentity).'" given');
		if(!filter_var($sAuthAccessEmailIdentity,FILTER_VALIDATE_EMAIL))throw new \InvalidArgumentException('AuthAccess email identity expects valid email, "'.$sAuthAccessEmailIdentity.'" given');

		$oAuthAccessRepository = $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository');

		if(!$oAuthAccessRepository->isEmailIdentityAvailable($sAuthAccessEmailIdentity))throw new \InvalidArgumentException('AuthAccess email identity "'.$sAuthAccessEmailIdentity.'" is not available');

		//Update AuthAccess email identity
		$oAuthAccessRepository->update(
			$this->getServiceLocator()->get('AccessControlService')->getAuthenticatedAuthAccess()->setAuthAccessEmailIdentity($sAuthAccessEmailIdentity)
		);
		return $this;
	}

	/**
	 * Change current authenticated AuthAccess username identity if available
	 * @param string $sAuthAccessUsernameIdentity
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Service\AuthAccessService
	 */
	public function changeAuthenticatedAuthAccessUsernameIdentity($sAuthAccessUsernameIdentity){
		if(!is_string($sAuthAccessUsernameIdentity))throw new \InvalidArgumentException('AuthAccess username identity expects string, "'.gettype($sAuthAccessUsernameIdentity).'" given');
		if(
			empty($sAuthAccessUsernameIdentity)
			|| strpos($sAuthAccessUsernameIdentity,' ') !== false
		)throw new \InvalidArgumentException('AuthAccess username identity expects string without spaces "'.$sAuthAccessUsernameIdentity.'" given');


		$oAuthAccessRepository = $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository');

		if(!$oAuthAccessRepository->isUsernameIdentityAvailable($sAuthAccessUsernameIdentity))throw new \InvalidArgumentException('AuthAccess email identity "'.$sAuthAccessUsernameIdentity.'" is not available');

		//Update AuthAccess username identity
		$oAuthAccessRepository->update(
			$this->getServiceLocator()->get('AccessControlService')->getAuthenticatedAuthAccess()->setAuthAccessUsernameIdentity($sAuthAccessUsernameIdentity)
		);
		return $this;
	}

	/**
	 * Change current authenticated AuthAccess credential
	 * @param string $sAuthAccessCredential
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Service\AuthAccessService
	 */
	public function changeAuthenticatedAuthAccessCredential($sAuthAccessCredential){
		if(!is_string($sAuthAccessCredential))throw new \InvalidArgumentException('AuthAccess credential expects string, "'.gettype($sAuthAccessCredential).'" given');
		if(empty($sAuthAccessCredential))throw new \InvalidArgumentException('AuthAccess credential is empty');

		//Crypter
		$oBCrypt = new \Zend\Crypt\Password\Bcrypt();

		//Update AuthAccess credential
		$this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->update(
			$this->getServiceLocator()->get('AccessControlService')->getAuthenticatedAuthAccess()->setAuthAccessCredential($oBCrypt->create(md5($sAuthAccessCredential)))
		);
		return $this;
	}
}