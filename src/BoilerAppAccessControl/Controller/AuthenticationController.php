<?php
namespace BoilerAppAccessControl\Controller;
class AuthenticationController extends \BoilerAppDisplay\Mvc\Controller\AbstractActionController{
	/**
	 * Show authenticate form or process authenticate attempt
	 * @throws \UnexpectedValueException
	 * @return \Zend\View\Model\ViewModel
	 */
	public function authenticateAction(){
		//If user is already logged in, redirect him
		if($this->getServiceLocator()->get('AccessControlAuthenticationService')->hasIdentity())return $this->redirectUser();

		//Define title
		$this->layout()->title = $this->getServiceLocator()->get('Translator')->translate('sign_in');

		//Assign form
		$this->view->form = $this->getServiceLocator()->get('AuthenticateForm');

		if(
			$this->getRequest()->isPost() && $this->view->form->setData($this->params()->fromPost())->isValid()
			&& ($aData = $this->view->form->getData())
			&& ($bReturn = $this->getServiceLocator()->get('AuthenticationService')->authenticate(
				\BoilerAppAccessControl\Service\AuthenticationService::LOCAL_AUTHENTICATION,
				$aData['auth_access_identity'],
				$aData['auth_access_credential'],
				!!$aData['auth_access_remember']
			)) === true
		)return $this->redirectUser();

		if(isset($bReturn))$this->view->error = $bReturn;
		return $this->view;
	}

	/**
	 * Show Reset credential form, or process form submit request
	 * @throws \LogicException
	 * @return \Zend\View\Model\ViewModel
	 */
	public function forgottenCredentialAction(){
		//Define title
		$this->layout()->title = $this->getServiceLocator()->get('Translator')->translate('reset_credential');

		//Assign form
		$this->view->form = $this->getServiceLocator()->get('ResetCredentialForm');

		if(
			$this->getRequest()->isPost()
			&& $this->view->form->setData($this->params()->fromPost())->isValid()
			&& ($aData = $this->view->form->getData())
			&& ($bReturn = $this->getServiceLocator()->get('AuthenticationService')->sendConfirmationResetCredential($aData['auth_access_identity'])) === true
		)$this->view->credentialReset = true;
		elseif(isset($bReturn))$this->view->error = $bReturn;
		return $this->view;
	}

	/**
	 * Process reset credential request
	 * @throws \LogicException
	 * @return \Zend\View\Model\ViewModel
	 */
	public function resetCredentialAction(){
		if(!($sPublicKey = $this->params('public_key')))throw new \LogicException('Public key param is missing');
		if(!($sEmailIdentity = $this->params('email_identity')))throw new \LogicException('Email identity param is missing');

		//Define title
		$this->layout()->title = $this->getServiceLocator()->get('Translator')->translate('reset_credential');
		$this->getServiceLocator()->get('AuthenticationService')->resetCredential($sPublicKey,$sEmailIdentity);
		return $this->view;
	}

	/**
	 * Logout user
	 * @return \Zend\Http\Response
	 */
	public function logoutAction(){
		if($this->getServiceLocator()->get('AccessControlAuthenticationService')->hasIdentity())$this->getServiceLocator()->get('AuthenticationService')->logout();
		return $this->redirectUser();
	}
}