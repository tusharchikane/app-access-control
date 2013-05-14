<?php
namespace BoilerAppAccessControl\Factory;
class ChangeAuthAccessCredentialFormFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \BoilerAppAccessControl\Form\ChangeAuthAccessCredentialForm
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oForm = new \BoilerAppAccessControl\Form\ChangeAuthAccessCredentialForm('change_auth_access_credential');
		return $oForm
			->setTranslator($oServiceLocator->get('translator'))
		 	->setInputFilter(new \BoilerAppAccessControl\InputFilter\ChangeAuthAccessCredentialInputFilter())->prepare();
    }
}