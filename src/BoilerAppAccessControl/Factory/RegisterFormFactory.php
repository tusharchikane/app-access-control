<?php
namespace BoilerAppAccessControl\Factory;
class RegisterFormFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \BoilerAppAccessControl\Form\RegisterForm
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oTranslator = $oServiceLocator->get('translator');
		$oForm = new \BoilerAppAccessControl\Form\RegisterForm('register');
		return $oForm->setTranslator($oTranslator)
		->setCaptcha($oServiceLocator->get('Captcha'))
		->setInputFilter(new \BoilerAppAccessControl\InputFilter\RegisterInputFilter(
			$oServiceLocator->get('BoilerAppAccessControl\Repository\AuthAccessRepository'),
			$oTranslator
		))->prepare();
    }
}