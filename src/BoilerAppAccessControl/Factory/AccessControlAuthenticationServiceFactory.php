<?php
namespace BoilerAppAccessControl\Factory;
class AccessControlAuthenticationServiceFactory implements \Zend\ServiceManager\FactoryInterface{
	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$aConfiguration = $oServiceLocator->get('config');
		return \BoilerAppAccessControl\Authentication\AccessControlAuthenticationService::factory(
			isset($aConfiguration['authentication'])?$aConfiguration['authentication']:array(),
			$oServiceLocator
		);
    }
}