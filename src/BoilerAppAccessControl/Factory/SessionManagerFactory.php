<?php
namespace BoilerAppAccessControl\Factory;
class SessionManagerFactory implements \Zend\ServiceManager\FactoryInterface{
	/**
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \Zend\Session\SessionManager
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		return new \Zend\Session\SessionManager();
    }
}