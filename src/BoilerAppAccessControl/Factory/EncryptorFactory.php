<?php
namespace BoilerAppAccessControl\Factory;
class EncryptorFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \Zend\Crypt\Password\Bcrypt
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		return new \Zend\Crypt\Password\Bcrypt();
    }
}