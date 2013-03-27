<?php
namespace BoilerAppAccessControl\Factory;
class AuthenticateFormFactory implements \Zend\ServiceManager\FactoryInterface{
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oForm = new \BoilerAppAccessControl\Form\AuthenticateForm('authenticate');
		return $oForm->setInputFilter(new \BoilerAppAccessControl\InputFilter\AuthenticateInputFilter())->prepare();
    }
}