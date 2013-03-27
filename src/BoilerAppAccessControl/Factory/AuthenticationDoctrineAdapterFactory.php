<?php
namespace BoilerAppAccessControl\Factory;
class AuthenticationDoctrineAdapterFactory implements \Zend\ServiceManager\FactoryInterface{
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		return new \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter($oServiceLocator->get('AccessControlService'));
    }
}