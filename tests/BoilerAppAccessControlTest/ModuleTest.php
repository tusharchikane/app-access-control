<?php
namespace BoilerAppAccessControlTest;
class ModuleTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractModuleTestCase{
	public function testOnBootstrap(){
		$oEvent = new \Zend\Mvc\MvcEvent();
		$aConfiguration = $this->getServiceManager()->get('Config');
		$oEvent->setViewModel(new \Zend\View\Model\ViewModel())
		->setApplication($this->getServiceManager()->get('Application'))
		->setRouter(\Zend\Mvc\Router\Http\TreeRouteStack::factory(isset($aConfiguration['router'])?$aConfiguration['router']:array()))
		->setRouteMatch(new \Zend\Mvc\Router\RouteMatch(array('controller' => 'index','action' => 'index')));

		$this->module->onBootstrap($oEvent->setName(\Zend\Mvc\MvcEvent::EVENT_BOOTSTRAP));
	}
}