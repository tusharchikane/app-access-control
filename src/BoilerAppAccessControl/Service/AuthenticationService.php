<?php
namespace BoilerAppAccessControl\Service;
class AuthenticationService implements \Zend\ServiceManager\ServiceLocatorAwareInterface{
	use \Zend\ServiceManager\ServiceLocatorAwareTrait;

	const LOCAL_AUTHENTICATION = 'LocalAuth';

	/**
	 * Login user
	 * @param string $sAdapterName
	 * @throws \InvalidArgumentException
	 * @return string|boolean
	 */
	public function authenticate($sAdapterName){
		if(!is_string($sAdapterName))throw new \InvalidArgumentException('Adapter\'s name expects string, "'.gettype($sAdapterName).'" given');

		//Performs authentication attempt
		$iResult = call_user_func_array(
			array($this->getServiceLocator()->get('AccessControlAuthenticationService'),'authenticate'),
			func_get_args()
		);
		switch(true){
			case $iResult === \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_VALID:
				return true;

			case $iResult === \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_IDENTITY_WRONG:
				return $this->getServiceLocator()->get('translator')->translate('email_or_credential_wrong');

			case $iResult === \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::AUTH_RESULT_AUTH_ACCESS_STATE_PENDING:
				return $this->getServiceLocator()->get('translator')->translate('auth_access_state_pending');

			//Unknown error
			default:
				return $this->getServiceLocator()->get('translator')->translate($iResult);
		}
	}

	/**
	 * @param string $sAuthAccessIdentity
	 * @throws \InvalidArgumentException
	 * @return boolean|string
	 */
	public function sendConfirmationResetCredential($sAuthAccessIdentity){
		if(empty($sAuthAccessIdentity) || !is_string($sAuthAccessIdentity))throw new \InvalidArgumentException(sprintf(
			'AuthAccess identity expects a not empty string, "%s" given',
			is_scalar($sAuthAccessIdentity)?$sAuthAccessIdentity:gettype($sAuthAccessIdentity)
		));

		//Retrieve AccessControl service
		$oAccessControlService = $this->getServiceLocator()->get('AccessControlService');

		if(!($oAuthAccess = $oAccessControlService->getAuthAccessFromIdentity($sAuthAccessIdentity)))return $this->getServiceLocator()->get('translator')->translate('identity_does_not_match_any_registered_user');

		//If AuthAccess is in pending state
		if($oAuthAccess->getAuthAccessState() !== \BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_ACTIVE_STATE)return $this->getServiceLocator()->get('translator')->translate('auth_access_pending');

		//Reset public key
		$oAuthAccess->setAuthAccessPublicKey($this->getServiceLocator()->get('Encryptor')->create($sPublicKey = $oAccessControlService->generateAuthAccessPublicKey()));
		$this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->update($oAuthAccess);

		//Create email view body
		$oView = new \Zend\View\Model\ViewModel(array(
			'auth_access_public_key' => $sPublicKey,
			'auth_access_email_identity' => $oAuthAccess->getAuthAccessEmailIdentity()
		));

		//Retrieve Messenger service
		$oMessengerService = $this->getServiceLocator()->get('MessengerService');

		$oMessage = new \BoilerAppMessenger\Message\Message();
		$oMessengerService->sendMessage(
			$oMessage->setFrom($oMessengerService->getSystemUser())
			->setTo($oAuthAccess->getAuthAccessUser())
			->setSubject($this->getServiceLocator()->get('translator')->translate('reset_credential'))
			->setBody($oView->setTemplate('mail/authentication/confirm-reset-credential')),
			\BoilerAppMessenger\Media\Mail\MailMessageRenderer::MEDIA
		);
		return true;
	}

	/**
	 * @param string $sResetKey
	 * @throws \Exception
	 * @return \BoilerAppAccessControl\Service\AuthenticationService
	 */
	public function resetCredential($sPublicKey, $sEmailIdentity){
		if(empty($sPublicKey) || !is_string($sPublicKey))throw new \InvalidArgumentException('Public key expects a not empty string , "'.gettype($sPublicKey).'" given');
		if(empty($sEmailIdentity) || !is_string($sEmailIdentity))throw new \InvalidArgumentException('Email identity expects a not empty string , "'.gettype($sEmailIdentity).'" given');

		if(!($oAuthAccess = $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->findOneBy(array(
			'auth_access_email_identity' => $sEmailIdentity
		))))throw new \LogicException('AuthAccess with email identity "'.$sEmailIdentity.'" does not exist');

		//Verify public key
		$oEncryptor = $this->getServiceLocator()->get('Encryptor');
		if(!$oEncryptor->verify($sPublicKey, $oAuthAccess->getAuthAccessPublicKey()))throw new \LogicException(sprintf(
			'Public key "%s" is not valid for email identity "%s"',
			$sPublicKey,$sEmailIdentity
		));

		//Check AuthAccess state
		elseif($oAuthAccess->getAuthAccessState() !== \BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_ACTIVE_STATE)throw new \LogicException(sprintf(
			'AuthAccess "%s" is not active',
			$oAuthAccess->getAuthAccessId()
		));

		//Update AuthAccess entity

		$this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->update($oAuthAccess
		//Reset credential
		->setAuthAccessCredential($oEncryptor->create(md5($sCredential = md5(date('Y-m-d').str_shuffle(uniqid())))))
		//Reset public key
		->setAuthAccessPublicKey($oEncryptor->create($this->getServiceLocator()->get('AccessControlService')->generateAuthAccessPublicKey())));

		//Create email view body
		$oView = new \Zend\View\Model\ViewModel(array(
			'auth_access_username_identity' => $oAuthAccess->getAuthAccessUsernameIdentity(),
			'auth_access_credential' => $sCredential
		));

		//Retrieve Messenger service
		$oMessengerService = $this->getServiceLocator()->get('MessengerService');

		$oMessage = new \BoilerAppMessenger\Message\Message();
		$oMessengerService->sendMessage(
			$oMessage->setFrom($oMessengerService->getSystemUser())
			->setTo($oAuthAccess->getAuthAccessUser())
			->setSubject($this->getServiceLocator()->get('translator')->translate('reset_credential'))
			->setBody($oView->setTemplate('mail/authentication/credential-reset')),
			\BoilerAppMessenger\Media\Mail\MailMessageRenderer::MEDIA
		);
		return $this;
	}

	/**
	 * Log out current logged user
	 * @return \BoilerAppAccessControl\Service\AuthenticationService
	 */
	public function logout(){
		$this->getServiceLocator()->get('AccessControlAuthenticationService')->clearIdentity();
		return $this;
	}
}