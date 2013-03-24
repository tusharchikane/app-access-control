<?php
namespace BoilerAppAccessControl\Factory;
class ResetCredentialFormFactory implements \Zend\ServiceManager\FactoryInterface{
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oForm = new \BoilerAppAccessControl\Form\ResetCredentialForm('reset-credential');
		return $oForm->setInputFilter(new \BoilerAppAccessControl\InputFilter\ResetCredentialInputFilter())->prepare();
    }
}