<?php
namespace BoilerAppAccessControlTest\Authentication\Adapter;
class AuthenticationDoctrineAdapterFail extends \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter{
	/**
	 * @var int
	 */
	protected $resultCode;

	/**
	 * @var array
	 */
	protected $messages = array();

	/**
	 * @see \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter::postAuthenticate()
	 * @param int $iResultCode
	 * @param array $aMessages
	 */
	public function postAuthenticate($iResultCode,$aMessages = array()){
		$this->resultCode = $iResultCode;
		$this->messages = $aMessages;
	}

	/**
	 * @see \BoilerAppAccessControl\Authentication\Adapter\AuthenticationDoctrineAdapter::authenticate()
	 * @return \BoilerAppAccessControlTest\Authentication\Adapter\WrongResult
	 */
	public function authenticate(){
		//Reset previous identity datas
		$this->resultRow = null;
		//Fail
		return new \BoilerAppAccessControlTest\Authentication\Adapter\WrongResult($this->resultCode,null,$this->messages);
	}
}