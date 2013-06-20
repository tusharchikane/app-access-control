<?php
namespace BoilerAppAccessControl\Controller;
class AuthAccessController extends \BoilerAppDisplay\Mvc\Controller\AbstractActionController{

	/**
	 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
	 * @return \Zend\View\Model\ViewModel
	 */
	public function indexAction(){
		//Define title
		$this->layout()->title = $this->getServiceLocator()->get('Translator')->translate('auth_access_management');
		$this->view->authenticatedAuthAccess = $this->getServiceLocator()->get('AccessControlService')->getAuthenticatedAuthAccess();
		return $this->view;
	}

	/**
	 * Show change AuthAccess email identity form or process AuthAccess email identity change attempt
	 * @throws \LogicException
	 * @return \Zend\View\Model\ViewModel
	 */
	public function changeEmailIdentityAction(){
		if(!$this->getRequest()->isXmlHttpRequest())throw new \LogicException('Only ajax requests are allowed for action "changeEmailIdentity"');

		//Assign form
		$this->view->form = $this->getServiceLocator()->get('ChangeAuthAccessEmailIdentityForm');
		if(
			$this->getRequest()->isPost()
			&& $this->view->form->setData($this->params()->fromPost())->isValid()
			&& ($aData = $this->view->form->getData())
			&& $this->getServiceLocator()->get('AuthAccessService')->changeAuthenticatedAuthAccessEmailIdentity($aData['new_auth_access_email_identity'])
		)$this->view->emailConfirmationSent = true;
		return $this->view;
	}

	/**
	 * Process change email identity confirmation
	 * @throws \LogicException
	 * @return \Zend\View\Model\ViewModel
	 */
	public function confirmChangeEmailIdentityAction(){
		if(!($sPublicKey = $this->params('public_key')))throw new \LogicException('"public_key" param is missing');
		if(!($sEmailIdentity = $this->params('email_identity')))throw new \LogicException('"email_identity" param is missing');

		if(($bReturn = $this->getServiceLocator()->get('AuthAccessService')->confirmChangeAuthenticatedAuthAccessEmailIdentity($sPublicKey,$sEmailIdentity)) !== true)$this->view->error = $bReturn;
		return $this->view;
	}

	/**
	 * Show change AuthAccess username identity form or process AuthAccess username identity change attempt
	 * @throws \LogicException
	 * @return \Zend\View\Model\ViewModel
	 */
	public function changeUsernameIdentityAction(){
		if(!$this->getRequest()->isXmlHttpRequest())throw new \LogicException('Only ajax requests are allowed for action "changeUsernameIdentity"');

		//Assign form
		$this->view->form = $this->getServiceLocator()->get('ChangeAuthAccessUsernameIdentityForm');
		if(
			$this->getRequest()->isPost()
			&& $this->view->form->setData($this->params()->fromPost())->isValid()
			&& ($aData = $this->view->form->getData())
			&& $this->getServiceLocator()->get('AuthAccessService')->changeAuthenticatedAuthAccessUsernameIdentity($aData['new_auth_access_username_identity'])
		)$this->view->usernameIdentityChanged = true;
		return $this->view;
	}

	/**
	 * Show change AuthAccess credential form or process AuthAccess credential change attempt
	 * @throws \LogicException
	 * @return \Zend\View\Model\ViewModel
	 */
	public function changeCredentialAction(){
		if(!$this->getRequest()->isXmlHttpRequest())throw new \LogicException('Only ajax requests are allowed for action "changeCredential"');

		//Assign form
		$this->view->form = $this->getServiceLocator()->get('ChangeAuthAccessCredentialForm');
		if(
			$this->getRequest()->isPost()
			&& $this->view->form->setData($this->params()->fromPost())->isValid()
			&& ($aData = $this->view->form->getData())
			&& $this->getServiceLocator()->get('AuthAccessService')->changeAuthenticatedAuthAccessCredential($aData['new_auth_access_credential'])
		)$this->view->credentialChanged = true;
		return $this->view;
	}

	/**
	 * Show remove AuthAccces confirmation form or process AuthAccess remove attempt
	 * @throws \LogicException
	 * @return \Zend\View\Model\ViewModel
	 */
	public function removeAuthAccessAction(){
		//Assign form
		$this->view->form = $this->getServiceLocator()->get('RemoveAuthAccessForm');
		if(
			$this->getRequest()->isPost()
			&& $this->view->form->setData($this->params()->fromPost())->isValid()
			&& ($aData = $this->view->form->getData())
			&& $this->getServiceLocator()->get('AuthAccessService')->removeAuthenticatedAuthAccess($aData['auth_access_credential'])
		)$this->view->authAccessRemoved = true;
		return $this->view;
	}
}