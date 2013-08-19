<?php
namespace BoilerAppAccessControl\Authentication\Storage;
interface StorageInterface extends \Zend\Authentication\Storage\StorageInterface{

	/**
	 * @return \BoilerAppAccessControl\Authentication\Storage\StorageInterface
	 */
	public function rememberMe();

	/**
	 * @return \BoilerAppAccessControl\Authentication\Storage\StorageInterface
	 */
	public function forgetMe();
}