<?php
namespace BoilerAppAccessControl\Factory;
class AuthenticationStorageFactory implements \Zend\ServiceManager\FactoryInterface{
	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @throws \LogicException
	 * @return \BoilerAppAccessControl\Authentication\Storage\Session
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$aConfiguration = $oServiceLocator->get('Config');
		if(empty($aConfiguration['SessionNamespace']))throw new \LogicException('Session namespace config is undefined');
		return new \BoilerAppAccessControl\Authentication\Storage\SessionStorage($aConfiguration['SessionNamespace'],null,$oServiceLocator->get('SessionManager'));
    }
}