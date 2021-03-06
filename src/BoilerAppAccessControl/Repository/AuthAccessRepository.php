<?php
namespace BoilerAppAccessControl\Repository;
class AuthAccessRepository extends \BoilerAppDb\Repository\AbstractEntityRepository{

	/** User states */
	const AUTH_ACCESS_PENDING_STATE = 'PENDING';
	const AUTH_ACCESS_ACTIVE_STATE = 'ACTIVE';

	/**
	 * @var array
	 */
	protected $availableIdentities = array(
		'auth_access_email_identity',
		'auth_access_username_identity'
	);

	/**
	 * @return array
	 */
	public function getAvailableIdentities(){
		return $this->availableIdentities;
	}

	/**
	 * Check if an email is available for use
	 * @param string $sEmail
	 * @throws \InvalidArgumentException
	 * @return boolean
	 */
	public function isEmailIdentityAvailable($sEmail){
		if(empty($sEmail) || !is_string($sEmail))throw new \InvalidArgumentException('Email expects string, "'.(empty($sEmail)?'':gettype($sEmail)).'" given');
		return !$this->findOneBy(array('auth_access_email_identity' => $sEmail));
	}

	/**
	 * Check if a usename is available for use
	 * @param string $sUserName
	 * @throws \InvalidArgumentException
	 * @return boolean
	 */
	public function isUsernameIdentityAvailable($sUserName){
		if(empty($sUserName) || !is_string($sUserName))throw new \InvalidArgumentException('Username expects string, "'.(empty($sUserName)?'':gettype($sUserName)).'" given');
		return !$this->findOneBy(array('auth_access_username_identity' => $sUserName));
	}
}