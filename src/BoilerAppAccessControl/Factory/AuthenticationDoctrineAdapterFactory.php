<?php
namespace BoilerAppAccessControl\Factory;
class AuthenticationDoctrineAdapterFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		return new \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter(
			$oServiceLocator->get('AccessControlService'),
			$oServiceLocator->get('Encryptor')
		);
    }
}