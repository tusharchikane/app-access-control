<?php
namespace BoilerAppAccessControlTest;
class ModuleTest extends \PHPUnit_Framework_TestCase{
	/**
	 * @var \BoilerAppAccessControl\Module
	 */
	protected $module;

	/**
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp(){
		$this->module = new \BoilerAppAccessControl\Module();
		$this->event = new \Zend\Mvc\MvcEvent();

		$oServiceManager = \BoilerAppAccessControlTest\Bootstrap::getServiceManager();

		$oRouteMatch = new \Zend\Mvc\Router\RouteMatch(array('controller' => 'index','action' => 'index'));
		$aConfiguration = $oServiceManager->get('Config');
		$this->event
			->setViewModel(new \Zend\View\Model\ViewModel())
			->setApplication($oServiceManager->get('Application'))
			->setRouter(\Zend\Mvc\Router\Http\TreeRouteStack::factory(isset($aConfiguration['router'])?$aConfiguration['router']:array()))
			->setRouteMatch($oRouteMatch);
	}

	public function testOnBootstrap(){
		$this->module->onBootstrap($this->event->setName(\Zend\Mvc\MvcEvent::EVENT_BOOTSTRAP));
	}

    public function testGetConfig(){
        $this->assertTrue(is_array($this->module->getConfig()));
    }
}