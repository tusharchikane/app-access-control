<?php
namespace BoilerAppAccessControl\Entity;
/**
 * @\Doctrine\ORM\Mapping\Entity(repositoryClass="\BoilerAppAccessControl\Repository\AuthProviderRepository")
 * @\Doctrine\ORM\Mapping\Table(name="auth_providers")
 */
class AuthProviderEntity extends \BoilerAppDb\Entity\AbstractEntity{

	/**
     * @var \BoilerAppUser\Entity\UserEntity
     * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="BoilerAppUser\Entity\UserEntity")
	 */
	protected $user;

	/**
	 * @var string
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="string",length=50)
	 */
	protected $provider_id;

	/**
	 * @var string
	 * @\Doctrine\ORM\Mapping\Column(type="string",length=255)
	 */
	protected $provider_name;

	/**
	 * @param \BoilerAppUser\Entity\UserEntity $oUser
	 * @return \BoilerAppAccessControl\Entity\AuthProviderEntity
	 */
	public function setUser(\BoilerAppUser\Entity\UserEntity $oUser){
		$this->user = $oUser;
		return $this;
	}

	/**
	 * @return \BoilerAppUser\Entity\UserEntity
	 */
	public function getUser(){
		return $this->user;
	}

	/**
	 * @param string $sProviderId
	 * @return \BoilerAppAccessControl\Entity\AuthProviderEntity
	 */
	public function setProviderId($sProviderId){
		$this->provider_id = $sProviderId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getProviderId(){
		return $this->provider_id;
	}

	/**
	 * @param string $sProviderName
	 * @return \BoilerAppAccessControl\Entity\AuthProviderEntity
	 */
	public function setProviderName($sProviderName){
		$this->provider_name = $sProviderName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getProviderName(){
		return $this->provider_name;
	}
}