<?php
namespace BoilerAppAccessControl;
class Module{

	/**
	 * @param \Zend\Mvc\MvcEvent $oEvent
	 */
	public function onBootstrap(\Zend\Mvc\MvcEvent $oEvent){
		$oServiceManager = $oEvent->getApplication()->getServiceManager();

		$oEventManager = $oEvent->getApplication()->getEventManager();

		//Process for render MVC event
		if($oServiceManager->has('ViewRenderer') && $oServiceManager->get('ViewRenderer') instanceof \Zend\View\Renderer\PhpRenderer)$oEventManager->attach(
			\Zend\Mvc\MvcEvent::EVENT_RENDER,
			array($this, 'onRender')
		);
	}

	/**
	 * @param \Zend\Mvc\MvcEvent $oEvent
	 */
	public function onRender(\Zend\Mvc\MvcEvent $oEvent){
		$oRequest = $oEvent->getRequest();
		if(
			($oView = $oEvent->getResult()) instanceof \Zend\View\Model\ModelInterface
			&& !$oView->terminate()
		){
			//Set authenticatedUser var to layout
			$oServiceManager = $oEvent->getApplication()->getServiceManager();
			if($oServiceManager->get('AccessControlAuthenticationService')->hasIdentity())$oEvent->getViewModel()->setVariable(
				'authenticatedUser',
				$oServiceManager->get('AccessControlService')->getAuthenticatedAuthAccess()->getAuthAccessUser()
			);
		}
	}

	/**
     * @return array
     */
    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
     * @return array
     */
    public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            )
        );
    }
}