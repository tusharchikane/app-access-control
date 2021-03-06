<?php
namespace BoilerAppAccessControl\Mvc\Controller\Plugin;
class RedirectUser extends \Zend\Mvc\Controller\Plugin\AbstractPlugin{
	/**
	 * @var string
	 */
	protected $defaultRedirect;

	/**
	 * Redirect to a defined url, use "redirect" session value if exists, else defaultRedirect config
	 * @throws \LogicException
	 * @return \Zend\Http\Response
	 */
	public function __invoke(){
		$oController = $this->getController();
		$oSessionContainer = $oController->getServiceLocator()->get('SessionContainer');
		$sRedirectUrl = $oSessionContainer->redirect;
		unset($oSessionContainer->redirect);

		//If redirect url is the same as the current url
		if(($sRedirectUrl = empty($sRedirectUrl)?$this->getDefaultRedirect():$sRedirectUrl) === $oController->getRequest()->getUri()->getPath())throw new \LogicException(sprintf(
			'Redirect url "%s" is the same as current url "%s"',
			$sRedirectUrl, $oController->getRequest()->getUriString()
		));
		return $oController->redirect()->toUrl($sRedirectUrl);
	}

	/**
	 * @throws \LogicException
	 * @return string
	 */
	public function getDefaultRedirect(){
		if(is_string($this->defaultRedirect))return $this->defaultRedirect;
		//Set default redirect from configuration
		else{
			$aConfiguration = $this->getController()->getServiceLocator()->get('Config');
			if(empty($aConfiguration['authentication']['defaultRedirect']))throw new \LogicException('Default redirect config is undefined');
			return $this->setDefaultRedirect($aConfiguration['authentication']['defaultRedirect'])->defaultRedirect;
		}
	}

	/**
	 * @param string $sDefaultRedirect
	 * @throws \InvalidArgumentException
	 * @return \BoilerAppAccessControl\Mvc\Controller\Plugin\RedirectUser
	 */
	public function setDefaultRedirect($sDefaultRedirect){
		if(!is_string($sDefaultRedirect))throw new \InvalidArgumentException('Default redirect config expects string, "'.gettype($sDefaultRedirect).'" given');

		if(!(($oController = $this->getController()) instanceof \Zend\Stdlib\DispatchableInterface))throw new \LogicException('RedirectUser plugin requires controller; none found');

		$oEvent = $oController->getEvent();
		$oRouter = null;

		if($oEvent instanceof \Zend\Mvc\MvcEvent)$oRouter = $oEvent->getRouter();
		elseif($oEvent instanceof \Zend\EventManager\EventInterface)$oRouter = $oEvent->getParam('router',false);

		if(!($oRouter instanceof \Zend\Mvc\Router\SimpleRouteStack))throw new \LogicException('RedirectUser plugin requires that controller event compose a router; none found');

		//Route
		if($oRouter->hasRoute(current(explode('/',$sDefaultRedirect,2))))$this->defaultRedirect = $oController->url()->fromRoute($sDefaultRedirect);

		//Url
		elseif($sFilterUrl = filter_var($sDefaultRedirect,FILTER_SANITIZE_URL))$this->defaultRedirect = $sFilterUrl;
		else throw new \InvalidArgumentException('Default redirect expects a route name or an url, "'.$sDefaultRedirect.'" given');
		return $this;
	}
}