<?php
namespace BoilerAppAccessControl\Factory;
class ChangeAuthAccessEmailIdentityFormFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \BoilerAppAccessControl\Form\ChangeAuthAccessEmailIdentityForm
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oForm = new \BoilerAppAccessControl\Form\ChangeAuthAccessEmailIdentityForm('change_auth_access_email_identity');
		return $oForm->setInputFilter(new \BoilerAppAccessControl\InputFilter\ChangeAuthAccessEmailIdentityInputFilter(
			$oServiceLocator->get('BoilerAppAccessControl\Repository\AuthAccessRepository'),
			$oServiceLocator->get('translator')
		))->prepare();
    }
}