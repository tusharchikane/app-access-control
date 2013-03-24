<?php
namespace BoilerAppAccessControl\Factory;
class BoilerAppAccessControlAuthenticationServiceFactory implements \Zend\ServiceManager\FactoryInterface{
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$aConfiguration = $oServiceLocator->get('config');
		return \BoilerAppAccessControl\Authentication\BoilerAppAccessControlAuthenticationService::factory(
			isset($aConfiguration['authentication'])?$aConfiguration['authentication']:array(),
			$oServiceLocator
		);
    }
}