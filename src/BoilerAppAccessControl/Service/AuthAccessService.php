<?php
namespace BoilerAppAccessControl\Service;
class AuthAccessService implements \Zend\ServiceManager\ServiceLocatorAwareInterface{
	use \Zend\ServiceManager\ServiceLocatorAwareTrait;

	/**
	 * Attempt to change current authenticated AuthAccess email identity if available
	 * @param string $sAuthAccessEmailIdentity
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Service\AuthAccessService
	 */
	public function changeAuthenticatedAuthAccessEmailIdentity($sAuthAccessEmailIdentity){
		if(!is_string($sAuthAccessEmailIdentity))throw new \InvalidArgumentException('AuthAccess email identity expects string, "'.gettype($sAuthAccessEmailIdentity).'" given');
		if(!filter_var($sAuthAccessEmailIdentity,FILTER_VALIDATE_EMAIL))throw new \InvalidArgumentException('AuthAccess email identity expects valid email, "'.$sAuthAccessEmailIdentity.'" given');

		$oAuthAccessRepository = $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository');

		if(!$oAuthAccessRepository->isEmailIdentityAvailable($sAuthAccessEmailIdentity))throw new \InvalidArgumentException('AuthAccess email identity "'.$sAuthAccessEmailIdentity.'" is not available');

		//Update AuthAcces public key
		$oAuthAccess = $this->getServiceLocator()->get('AccessControlService')->getAuthenticatedAuthAccess();
		$oAuthAccessRepository->update($oAuthAccess->setAuthAccessPublicKey($this->getServiceLocator()->get('Encryptor')->create(
			$sPublicKey = $this->getServiceLocator()->get('AccessControlService')->generateAuthAccessPublicKey()
		)));

		//Create email view body
		$oView = new \Zend\View\Model\ViewModel(array(
			'auth_access_email_identity' => $sAuthAccessEmailIdentity,
			'auth_access_public_key' => $sPublicKey
		));

		//Retrieve Messenger service
		$oMessengerService = $this->getServiceLocator()->get('MessengerService');

		//Send email confirmation to user
		$oMessage = new \BoilerAppMessenger\Message\Message();
		$oMessengerService->sendMessage(
			$oMessage->setFrom($oMessengerService->getSystemUser())
			->setTo($oAuthAccess->getAuthAccessUser())
			->setSubject($this->getServiceLocator()->get('translator')->translate('confirm_change_email'))
			->setBody($oView->setTemplate('mail/auth-access/confirm-change-email-identity')),
			\BoilerAppMessenger\Media\Mail\MailMessageRenderer::MEDIA
		);
		return $this;
	}

	/**
	 * @param string $sPublicKey
	 * @param string $sAuthAccessEmailIdentity
	 * @throws \InvalidArgumentException
	 * @return string|boolean : true if function succeed
	 */
	public function confirmChangeAuthenticatedAuthAccessEmailIdentity($sPublicKey, $sAuthAccessEmailIdentity){
		if(empty($sPublicKey) || !is_string($sPublicKey))throw new \InvalidArgumentException('Public key expects a not empty string , "'.gettype($sPublicKey).'" given');
		if(!is_string($sAuthAccessEmailIdentity))throw new \InvalidArgumentException('AuthAccess email identity expects string, "'.gettype($sAuthAccessEmailIdentity).'" given');
		if(!filter_var($sAuthAccessEmailIdentity,FILTER_VALIDATE_EMAIL))throw new \InvalidArgumentException('AuthAccess email identity expects valid email, "'.$sAuthAccessEmailIdentity.'" given');

		$oAuthAccessRepository = $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository');

		if(!$oAuthAccessRepository->isEmailIdentityAvailable($sAuthAccessEmailIdentity))throw new \InvalidArgumentException('AuthAccess email identity "'.$sAuthAccessEmailIdentity.'" is not available');

		$oAuthAccess = $this->getServiceLocator()->get('AccessControlService')->getAuthenticatedAuthAccess();

		//Verify public key
		if(!$this->getServiceLocator()->get('Encryptor')->verify($sPublicKey, $oAuthAccess->getAuthAccessPublicKey()))throw new \LogicException(sprintf(
			'Public key "%s" is not valid for email identity "%s"',
			$sPublicKey,$oAuthAccess->getAuthAccessEmailIdentity()
		));
		elseif($oAuthAccess->getAuthAccessEmailIdentity() === $sAuthAccessEmailIdentity)return $this->getServiceLocator()->get('translator')->translate('email_already_confirmed');

		//Update AuthAccess email identity
		$oAuthAccessRepository->update($oAuthAccess->setAuthAccessEmailIdentity($sAuthAccessEmailIdentity));

		return true;
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

		//Update AuthAccess credential
		$this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->update(
			$this->getServiceLocator()->get('AccessControlService')->getAuthenticatedAuthAccess()->setAuthAccessCredential($this->getServiceLocator()->get('Encryptor')->create(md5($sAuthAccessCredential)))
		);
		return $this;
	}

	/**
	 * Remove authenticated auth access & user
	 * @param string $sAuthAccessCredential
	 * @throws \LogicException
	 * @return \BoilerAppAccessControl\Service\AuthAccessService
	 */
	public function removeAuthenticatedAuthAccess($sAuthAccessCredential){
		if(!is_string($sAuthAccessCredential))throw new \InvalidArgumentException('AuthAccess credential expects string, "'.gettype($sAuthAccessCredential).'" given');
		if(empty($sAuthAccessCredential))throw new \InvalidArgumentException('AuthAccess credential is empty');

		$oServiceLocator = $this->getServiceLocator();
		$oAuthenticatedAuthAccess = $this->getServiceLocator()->get('AccessControlService')->getAuthenticatedAuthAccess();

		//Verify credential
		if(!$this->getServiceLocator()->get('Encryptor')->verify(md5($sAuthAccessCredential), $oAuthenticatedAuthAccess->getAuthAccessCredential()))throw new \LogicException(sprintf(
			'Credential is not valid for email identity "%s"',
			$sAuthAccessCredential,$oAuthenticatedAuthAccess->getAuthAccessEmailIdentity()
		));

		//Remove user
		$oServiceLocator->get('BoilerAppUser\Repository\UserRepository')->remove($oAuthenticatedAuthAccess->getAuthAccessUser());

		//Remove Auth access
		$oServiceLocator->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->remove($oAuthenticatedAuthAccess);

		//Log out
		$oServiceLocator->get('AuthenticationService')->logout();

		return $this;
	}
}