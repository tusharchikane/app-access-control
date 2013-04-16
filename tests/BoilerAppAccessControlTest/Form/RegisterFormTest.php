<?php
namespace BoilerAppAccessControlTest\Form;
class RegisterFormTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase{

	/**
	 * @var \BoilerAppAccessControl\Form\RegisterForm
	 */
	protected $registerForm;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase
	 */
	protected function setUp(){
		parent::setUp();
		$oRegisterFormFactory = new \BoilerAppAccessControl\Factory\RegisterFormFactory();
		$this->registerForm = $oRegisterFormFactory->createService($this->getServiceManager());
	}

	/**
	 * @expectedException LogicException
	 */
	public function testGetCaptchaUnset(){
		$oReflectionClass = new \ReflectionClass('BoilerAppAccessControl\Form\RegisterForm');
		$oCaptcha = $oReflectionClass->getProperty('captcha');
		$oCaptcha->setAccessible(true);
		$oCaptcha->setValue($this->registerForm, null);
		$this->registerForm->getCaptcha();
	}
}