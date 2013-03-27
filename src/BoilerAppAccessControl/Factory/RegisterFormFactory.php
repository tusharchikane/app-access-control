<?php
namespace BoilerAppAccessControl\Factory;
class RegisterFormFactory implements \Zend\ServiceManager\FactoryInterface{
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oTranslator = $oServiceLocator->get('translator');
		$oForm = new \BoilerAppAccessControl\Form\RegisterForm('register');
		return $oForm->setTranslator($oTranslator)
		->setInputFilter(new \BoilerAppAccessControl\InputFilter\RegisterInputFilter(
			$oServiceLocator->get('BoilerAppAccessControl\Repository\AuthAccessRepository'),
			$oTranslator
		))->prepare();
    }
}