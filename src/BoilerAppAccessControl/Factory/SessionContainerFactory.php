<?php
namespace BoilerAppAccessControl\Factory;
class SessionContainerFactory implements \Zend\ServiceManager\FactoryInterface{
	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @throws \LogicException
	 * @return \Zend\Session\Container
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$aConfiguration = $oServiceLocator->get('Config');
		if(empty($aConfiguration['SessionNamespace']))throw new \LogicException('Session namespace config is undefined');
		return new \Zend\Session\Container($aConfiguration['SessionNamespace'],$oServiceLocator->get('SessionManager'));
    }
}