<?php
namespace BoilerAppAccessControl\Entity;
/**
 * @\Doctrine\ORM\Mapping\Entity(repositoryClass="\BoilerAppAccessControl\Repository\AuthProviderRepository")
 * @\Doctrine\ORM\Mapping\Table(name="auth_providers")
 */
class AuthProviderEntity extends \BoilerAppDb\Entity\AbstractEntity{
	/**
	 * @var \BoilerAppAccessControl\Entity\AuthAccessEntity
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="BoilerAppAccessControl\Entity\AuthAccessEntity")
	 * @\Doctrine\ORM\Mapping\JoinColumn(name="auth_access_id", referencedColumnName="auth_access_id")
	 */
	protected $auth_provider_auth_access;

	/**
	 * @var string
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="string",length=50)
	 */
	protected $auth_provider_id;

	/**
	 * @var string
	 * @\Doctrine\ORM\Mapping\Column(type="string",length=255)
	 */
	protected $auth_provider_name;

	/**
	 * @param \BoilerAppAccessControl\Entity\AuthAccessEntity $oAuthAccess
	 * @return \BoilerAppAccessControl\Entity\AuthProviderEntity
	 */
	public function setAuthProviderAuthAccess($oAuthAccess){
		$this->auth_provider_auth_access = $oAuthAccess;
		return $this;
	}

	/**
	 * @return \BoilerAppAccessControl\Entity\AuthProviderEntity
	 */
	public function getAuthProviderAuthAccess(){
		return $this->auth_provider_auth_access;
	}


	/**
	 * @param string $sProviderId
	 * @return \BoilerAppAccessControl\Entity\AuthProviderEntity
	 */
	public function setAuthProviderId($sProviderId){
		$this->auth_provider_id = $sProviderId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthProviderId(){
		return $this->auth_provider_id;
	}

	/**
	 * @param string $sProviderName
	 * @return \BoilerAppAccessControl\Entity\AuthProviderEntity
	 */
	public function setAuthProviderName($sProviderName){
		$this->auth_provider_name = $sProviderName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthProviderName(){
		return $this->auth_provider_name;
	}
}