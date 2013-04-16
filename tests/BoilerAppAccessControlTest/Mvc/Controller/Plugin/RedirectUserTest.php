<?php
namespace BoilerAppAccessControlTest\Mvc\Controller\Plugin;
class RedirectUserTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase{
	/**
	 * @var \BoilerAppAccessControl\Mvc\Controller\Plugin\RedirectUser
	 */
	protected $redirectUser;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase
	 */
	protected function setUp(){
		parent::setUp();
		$oRegisterFormFactory = new \BoilerAppAccessControl\Factory\RegisterFormFactory();
		$this->redirectUser = new \BoilerAppAccessControl\Mvc\Controller\Plugin\RedirectUser();

		$oController = new \BoilerAppAccessControl\Controller\RegistrationController();

		$oEvent = new \Zend\EventManager\Event();
		$oReflectionClass = new \ReflectionClass('BoilerAppAccessControl\Controller\RegistrationController');
		$oEventProp = $oReflectionClass->getProperty('event');
		$oEventProp->setAccessible(true);
		$oEventProp->setValue($oController, $oEvent->setParam(
			'router',
			\Zend\Mvc\Router\Http\TreeRouteStack::factory(isset($aConfiguration['router'])?$aConfiguration['router']:array())
		));

		$this->redirectUser->setController($oController);
	}

	public function testSetDefaultRedirect(){
		$this->redirectUser->setDefaultRedirect('www.test.com');
		$this->assertEquals('www.test.com', $this->redirectUser->getDefaultRedirect());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetDefaultRedirectWithWrongUrl(){
		$this->redirectUser->setDefaultRedirect('');
	}
}