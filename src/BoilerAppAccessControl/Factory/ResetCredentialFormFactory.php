<?php
namespace BoilerAppAccessControl\Factory;
class ResetCredentialFormFactory implements \Zend\ServiceManager\FactoryInterface{
	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \BoilerAppAccessControl\Form\ResetCredentialForm
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oForm = new \BoilerAppAccessControl\Form\ResetCredentialForm('reset-credential');
		return $oForm->setInputFilter(new \BoilerAppAccessControl\InputFilter\ResetCredentialInputFilter())->prepare();
    }
}