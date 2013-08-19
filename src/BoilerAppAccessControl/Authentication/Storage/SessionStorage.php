<?php
namespace BoilerAppAccessControl\Authentication\Storage;
class SessionStorage extends \Zend\Authentication\Storage\Session implements \BoilerAppAccessControl\Authentication\Storage\StorageInterface{

	/**
	 * @return \BoilerAppAccessControl\Authentication\Storage\SessionStorage
	 */
	public function rememberMe(){
		$this->session->getManager()->rememberMe();
		return $this;
	}

	/**
	 * @return \BoilerAppAccessControl\Authentication\Storage\SessionStorage
	 */
	public function forgetMe(){
		$this->session->getManager()->forgetMe();
		return $this;
	}
}