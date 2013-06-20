<?php
namespace BoilerAppAccessControl\Entity;

/**
 * @\Doctrine\ORM\Mapping\Entity(repositoryClass="\BoilerAppAccessControl\Repository\AuthAccessRepository")
 * @\Doctrine\ORM\Mapping\Table(name="auth_access")
 */
class AuthAccessEntity extends \BoilerAppDb\Entity\AbstractEntity{
	/**
	 * @var int
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="integer")
	 * @\Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	 */
	protected $auth_access_id;

	/**
	 * @var string
	 * @\Doctrine\ORM\Mapping\Column(type="email",unique=true)
	 */
	protected $auth_access_email_identity;

	/**
	 * @var string
	 * @\Doctrine\ORM\Mapping\Column(type="string",unique=true,length=255)
	 */
	protected $auth_access_username_identity;

	/**
	 * @var string
	 * @\Doctrine\ORM\Mapping\Column(type="string",length=60)
	 */
	protected $auth_access_credential;

	/**
	 * @var string
	 * @\Doctrine\ORM\Mapping\Column(type="string",length=60)
	 */
	protected $auth_access_public_key;

	/**
	 * @var string
	 * @\Doctrine\ORM\Mapping\Column(type="authaccessstateenum")
	 */
	protected $auth_access_state;

	/**
	 * @var \BoilerAppUser\Entity\UserEntity
	 * @\Doctrine\ORM\Mapping\OneToOne(targetEntity="BoilerAppUser\Entity\UserEntity", mappedBy="user_auth_access")
	 */
	protected $auth_access_user;

	/**
	 * @return int
	 */
	public function getAuthAccessId(){
		return $this->auth_access_id;
	}

	/**
	 * @param string $sEmailIdentity
	 * @return \BoilerAppAccessControl\Entity\AuthAccessEntity
	 */
	public function setAuthAccessEmailIdentity($sEmailIdentity){
		$this->auth_access_email_identity = $sEmailIdentity;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthAccessEmailIdentity(){
		return $this->auth_access_email_identity;
	}

	/**
	 * @param string $sUsernameIdentity
	 * @return \BoilerAppAccessControl\Entity\AuthAccessEntity
	 */
	public function setAuthAccessUsernameIdentity($sUsernameIdentity){
		$this->auth_access_username_identity = $sUsernameIdentity;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthAccessUsernameIdentity(){
		return $this->auth_access_username_identity;
	}

	/**
	 * @param string $sCredential
	 * @return \BoilerAppAccessControl\Entity\AuthAccessEntity
	 */
	public function setAuthAccessCredential($sCredential){
		$this->auth_access_credential = $sCredential;
		return $this;
	}

	/**
	 * @return string $sCredential
	 */
	public function getAuthAccessCredential(){
		return $this->auth_access_credential;
	}

	/**
	 * @return string
	 */
	public function getAuthAccessPublicKey(){
		return $this->auth_access_public_key;
	}

	/**
	 * @param string $sPublicKey
	 * @return \BoilerAppAccessControl\Entity\AuthAccessEntity
	 */
	public function setAuthAccessPublicKey($sPublicKey){
		$this->auth_access_public_key = $sPublicKey;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthAccessState(){
		return $this->auth_access_state;
	}

	/**
	 * @param string $sState
	 * @return \BoilerAppAccessControl\Entity\AuthAccessEntity
	 */
	public function setAuthAccessState($sState){
		$this->auth_access_state = $sState;
		return $this;
	}

	/**
	 * @return \BoilerAppUser\Entity\UserEntity
	 */
	public function getAuthAccessUser(){
		return $this->auth_access_user;
	}
}