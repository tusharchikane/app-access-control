<?php
namespace BoilerAppAccessControl\Factory;
class AuthenticateFormFactory implements \Zend\ServiceManager\FactoryInterface{
	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \BoilerAppAccessControl\Form\AuthenticateForm
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oForm = new \BoilerAppAccessControl\Form\AuthenticateForm('authenticate');
		return $oForm->setInputFilter(new \BoilerAppAccessControl\InputFilter\AuthenticateInputFilter())->prepare();
    }
}