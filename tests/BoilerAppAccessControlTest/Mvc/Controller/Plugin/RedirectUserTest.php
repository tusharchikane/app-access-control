<?php
namespace BoilerAppAccessControlTest\Mvc\Controller\Plugin;
class RedirectUserTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase{
	/**
	 * @var \BoilerAppAccessControl\Mvc\Controller\Plugin\RedirectUser
	 */
	protected $redirectUser;

	/**
	 * @var \BoilerAppAccessControl\Controller\RegistrationController
	 */
	protected $controller;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase
	 */
	protected function setUp(){
		parent::setUp();
		$this->redirectUser = new \BoilerAppAccessControl\Mvc\Controller\Plugin\RedirectUser();

		$oServiceManager = $this->getServiceManager();
		$aConfiguration = $oServiceManager->get('Config');

		$this->controller = new \BoilerAppAccessControl\Controller\RegistrationController();
		$this->controller->setServiceLocator($oServiceManager);

		//Override event
		$oEvent = new \Zend\EventManager\Event();
		$oReflectionClass = new \ReflectionClass('BoilerAppAccessControl\Controller\RegistrationController');
		$oEventProp = $oReflectionClass->getProperty('event');
		$oEventProp->setAccessible(true);
		$oEventProp->setValue($this->controller, $oEvent->setParams(array(
			'router' => \Zend\Mvc\Router\Http\TreeRouteStack::factory(isset($aConfiguration['router'])?$aConfiguration['router']:array()),
			'response' => new \Zend\Http\Response()
		)));

		//Override request
		$oRequestProp = $oReflectionClass->getProperty('request');
		$oRequestProp->setAccessible(true);
		$oRequestProp->setValue($this->controller,\Zend\Http\Request::fromString('GET /test HTTP/1.1\r\n\r\nSome Content'));

		$this->redirectUser->setController($this->controller);
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

	/**
	 * @expectedException LogicException
	 */
	public function testInvokeWithSameCurrentAndRedirectUrl(){
		$this->redirectUser->setDefaultRedirect($this->controller->getRequest()->getUri()->getPath());
		$this->redirectUser->__invoke();
	}
}