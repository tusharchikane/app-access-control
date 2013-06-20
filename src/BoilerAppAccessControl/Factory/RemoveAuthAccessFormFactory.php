<?php
namespace BoilerAppAccessControl\Factory;
class RemoveAuthAccessFormFactory implements \Zend\ServiceManager\FactoryInterface{
	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \BoilerAppAccessControl\Form\RemoveAuthAccessForm
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oForm = new \BoilerAppAccessControl\Form\RemoveAuthAccessForm('remove-auth-access');
		return $oForm->setInputFilter(new \BoilerAppAccessControl\InputFilter\RemoveAuthAccessInputFilter(
			$oServiceLocator->get('Encryptor'),
			$oServiceLocator->get('AccessControlService')->getAuthenticatedAuthAccess()->getAuthAccessCredential()
		))->prepare();
    }
}