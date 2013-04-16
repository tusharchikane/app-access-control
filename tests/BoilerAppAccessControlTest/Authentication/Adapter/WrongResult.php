<?php
namespace BoilerAppAccessControlTest\Authentication\Adapter;
class WrongResult extends \Zend\Authentication\Result{

	/**
	 * Sets the result code, identity, and failure messages
	 * @param  int     $code
	 * @param  mixed   $identity
	 * @param  array   $messages
	 */
	public function __construct($code, $identity, array $messages = array()){
		$code = (int) $code;
		$this->code     = $code;
		$this->identity = $identity;
		$this->messages = $messages;
	}
}