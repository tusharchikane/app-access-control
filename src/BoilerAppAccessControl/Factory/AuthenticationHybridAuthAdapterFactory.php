<?php
namespace BoilerAppAccessControl\Factory;
class AuthenticationHybridAuthAdapterFactory implements \Zend\ServiceManager\FactoryInterface{
	/**
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @throws \LogicException
	 * @return \BoilerAppAccessControl\Authentication\Adapter\AuthenticationHybridAuthAdapter|Exception
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		try{
			$aConfiguration = $oServiceLocator->get('Config');
			if(!isset($aConfiguration['hybrid_auth']) || !is_array($aConfiguration['hybrid_auth']))throw new \LogicException('HybridAuth\'s config is undefined');
			$aConfiguration = $aConfiguration['hybrid_auth'];

			if(!isset($aConfiguration['base_url']))throw new \LogicException('HybridAuth\'s "base_url" config is undefined');

			//Rewrite base url
			$aConfiguration['base_url'] = $oServiceLocator->get('Router')->assemble(array(),array('name' => $aConfiguration['base_url'],'force_canonical' => true));

			//Initialize session manager
			$oServiceLocator->get('SessionManager')->start();
			return new \BoilerAppAccessControl\Authentication\Adapter\AuthenticationHybridAuthAdapter(new \Hybrid_Auth($aConfiguration));
		}
		catch(\Exception $oException){
			/* TODO remove */error_log(print_r($oException->__toString(),true));
		}
    }
}