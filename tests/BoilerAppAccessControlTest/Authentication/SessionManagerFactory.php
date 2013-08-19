<?php
namespace BoilerAppAccessControlTest\Authentication;
class SessionManagerFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \Zend\Session\SessionManager
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$oSessionConfig = new \Zend\Session\Config\SessionConfig();
		$aConfiguration = $oServiceLocator->get('config');
		if(isset($aConfiguration['authentication']['remember_me_ttl']))$oSessionConfig->setRememberMeSeconds($aConfiguration['authentication']['remember_me_ttl']);
		return new \BoilerAppAccessControlTest\Authentication\SessionManager($oSessionConfig);
    }
}