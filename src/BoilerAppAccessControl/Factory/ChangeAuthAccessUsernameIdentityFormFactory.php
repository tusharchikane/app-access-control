<?php
namespace BoilerAppAccessControl\Factory;
class ChangeAuthAccessUsernameIdentityFormFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \BoilerAppAccessControl\Form\ChangeAuthAccessUsernameIdentityForm
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oForm = new \BoilerAppAccessControl\Form\ChangeAuthAccessUsernameIdentityForm('change_auth_access_username_identity');
		return $oForm->setInputFilter(new \BoilerAppAccessControl\InputFilter\ChangeAuthAccessUsernameIdentityInputFilter(
			$oServiceLocator->get('BoilerAppAccessControl\Repository\AuthAccessRepository'),
			$oServiceLocator->get('translator')
		))->prepare();
    }
}