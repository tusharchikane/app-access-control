<?php
namespace BoilerAppAccessControl\Factory;
class CaptchaFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \Zend\Captcha\Image
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$aConfiguration = $oServiceLocator->get('Config');
		return new \Zend\Captcha\Image(isset($aConfiguration['captcha'])?$aConfiguration['captcha']:array());
    }
}