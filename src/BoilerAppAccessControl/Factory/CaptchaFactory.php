<?php
namespace BoilerAppAccessControl\Factory;
class CaptchaFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @return \Zend\Captcha\Image
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		return new \Zend\Captcha\Image(array(
			'font' =>  getcwd().'/data/fonts/ARIAL.ttf',
			'fsize' => 30,
			'width' => 220,
			'height' => 70,
			'dotNoiseLevel' => 40,
			'lineNoiseLevel' => 3,
			'wordlen' => 6,
			'imgDir' => './public/assets/captcha',
			'imgUrl' => '/assets/captcha/'
		));
    }
}