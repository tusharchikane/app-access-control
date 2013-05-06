<?php
namespace BoilerAppAccessControl\Service;
class RegistrationService implements \Zend\ServiceManager\ServiceLocatorAwareInterface{
	use \Zend\ServiceManager\ServiceLocatorAwareTrait;

	/**
	 * @param array $aRegisterData
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Service\RegistrationService
	 */
	public function register(array $aRegisterData){
		if(!isset(
			$aRegisterData['auth_access_email_identity'],
			$aRegisterData['auth_access_username_identity'],
			$aRegisterData['auth_access_credential']
		))throw new \InvalidArgumentException('Register data is invalid');

		$sUsernameIdentity = $aRegisterData['auth_access_username_identity'];
		if(!is_string($sUsernameIdentity) || strpos($sUsernameIdentity, ' ') !== false)throw new \InvalidArgumentException(sprintf(
			'UsernameIdentity expects string without spaces "%s" given',
			is_string($sUsernameIdentity)?$sUsernameIdentity:gettype($sUsernameIdentity)
		));

		//Create User
		$oUser = new \BoilerAppUser\Entity\UserEntity();
		//Set default display name
		$oUser->setUserDisplayName($this->getServiceLocator()->get('UserService')->getAvailableUserDisplayName(ucfirst($sUsernameIdentity)));
		$this->getServiceLocator()->get('BoilerAppUser\Repository\UserRepository')->create($oUser);

		$sEmailIdentity = $aRegisterData['auth_access_email_identity'];
		if(!is_string($sEmailIdentity) || !filter_var($sEmailIdentity,FILTER_VALIDATE_EMAIL))throw new \InvalidArgumentException(sprintf(
			'EmailIdentity expects valid email "%s" given',
			is_string($sEmailIdentity)?$sEmailIdentity:gettype($sEmailIdentity)
		));

		$sCredential = $aRegisterData['auth_access_credential'];
		if(!is_string($sCredential))throw new \InvalidArgumentException(sprintf(
			'Credential expects string "%s" given',
			gettype($sCredential)
		));

		//Crypter
		$oBCrypt = new \Zend\Crypt\Password\Bcrypt();

		//Create AuthAccess
		$oAuthAccess = new \BoilerAppAccessControl\Entity\AuthAccessEntity();
		$oAuthAccess->setAuthAccessEmailIdentity($sEmailIdentity)
		->setAuthAccessUsernameIdentity($sUsernameIdentity)

		//Set crypted credential
		->setAuthAccessCredential($oBCrypt->create(md5($sCredential)))
		->setAuthAccessPublicKey($oBCrypt->create($sPublicKey = $this->getServiceLocator()->get('AccessControlService')->generateAuthAccessPublicKey()))
		->setAuthAccessState(\BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_PENDING_STATE)
		->setAuthAccessUser($oUser);

		$this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->create($oAuthAccess);

		//Set auth access to user
		$oUser->setUserAuthAccess($oAuthAccess);

		//Create email view body
		$oView = new \Zend\View\Model\ViewModel(array(
			'auth_access_email_identity' => $sEmailIdentity,
			'auth_access_username_identity' => $sUsernameIdentity,
			'auth_access_credential' => $sCredential,
			'auth_access_public_key' => $sPublicKey
		));


		//Retrieve Messenger service
		$oMessengerService = $this->getServiceLocator()->get('MessengerService');

		//Send email confirmation to user
		$oMessage = new \BoilerAppMessenger\Message\Message();
		$oMessengerService->sendMessage(
			$oMessage->setFrom($oMessengerService->getSystemUser())
			->setTo($oUser)
			->setSubject($this->getServiceLocator()->get('translator')->translate('register'))
			->setBody($oView->setTemplate('email/registration/confirm-email')),
			\BoilerAppMessenger\Media\Mail\MailMessageRenderer::MEDIA
		);
		return $this;
	}

	/**
	 * @param string $sPublicKey
	 * @param string $sEmailIdentity
	 * @throws \InvalidArgumentException
	 * @return string|boolean : true if function succeed
	 */
	public function confirmEmail($sPublicKey, $sEmailIdentity){
		if(empty($sPublicKey) || !is_string($sPublicKey))throw new \InvalidArgumentException('Public key expects a not empty string , "'.gettype($sPublicKey).'" given');
		if(empty($sEmailIdentity) || !is_string($sEmailIdentity))throw new \InvalidArgumentException('Email identity expects a not empty string , "'.gettype($sEmailIdentity).'" given');

		if(!($oAuthAccess = $this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->findOneBy(array(
			'auth_access_email_identity' => $sEmailIdentity
		))))throw new \LogicException('AuthAccess with email identity "'.$sEmailIdentity.'" does not exist');

		//Crypter
		$oBCrypt = new \Zend\Crypt\Password\Bcrypt();
		if(!$oBCrypt->verify($sPublicKey, $oAuthAccess->getAuthAccessPublicKey()))throw new \LogicException(sprintf(
			'Public key "%s" is not valid for email identity "%s"',
			$sPublicKey,$sEmailIdentity
		));
		elseif($oAuthAccess->getAuthAccessState() === \BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_ACTIVE_STATE)return $this->getServiceLocator()->get('translator')->translate('email_already_confirmed');

		//Active AuthAccess
		$oAuthAccess->setAuthAccessState(\BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_ACTIVE_STATE);
		$this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->update($oAuthAccess);

		return true;
	}

	/**
	 * @param string $sAuthAccessIdentity
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Service\RegistrationService
	 */
	public function resendConfirmationEmail($sAuthAccessIdentity){
		if(empty($sAuthAccessIdentity) || !is_string($sAuthAccessIdentity))throw new \InvalidArgumentException(sprintf(
			'AuthAccess identity expects a not empty string, "%s" given',
			is_scalar($sAuthAccessIdentity)?$sAuthAccessIdentity:gettype($sAuthAccessIdentity)
		));

		$oAccessControlService = $this->getServiceLocator()->get('AccessControlService');

		if(!($oAuthAccess = $oAccessControlService->getAuthAccessFromIdentity($sAuthAccessIdentity)))throw new \LogicException(sprintf(
			'AuthAccess with identity "%s" does not exist',
			$sAuthAccessIdentity
		));

		//Reset public key
		$oBCrypt = new \Zend\Crypt\Password\Bcrypt();
		$oAuthAccess->setAuthAccessPublicKey($oBCrypt->create($sPublicKey = $oAccessControlService->generateAuthAccessPublicKey()));
		$this->getServiceLocator()->get('BoilerAppAccessControl\Repository\AuthAccessRepository')->update($oAuthAccess);

		//Create email view body
		$oView = new \Zend\View\Model\ViewModel(array(
			'auth_access_public_key' => $sPublicKey,
			'auth_access_email_identity' => $oAuthAccess->getAuthAccessEmailIdentity()
		));

		//Retrieve Messenger service
		$oMessengerService = $this->getServiceLocator()->get('MessengerService');

		//Send email confirmation to user
		$oMessage = new \BoilerAppMessenger\Message\Message();
		$oMessengerService->sendMessage(
			$oMessage->setFrom($oMessengerService->getSystemUser())
			->setTo($oAuthAccess->getAuthAccessUser())
			->setSubject($this->getServiceLocator()->get('translator')->translate('register'))
			->setBody($oView->setTemplate('email/registration/confirm-email')),
			\BoilerAppMessenger\Media\Mail\MailMessageRenderer::MEDIA
		);
		return $this;
	}
}