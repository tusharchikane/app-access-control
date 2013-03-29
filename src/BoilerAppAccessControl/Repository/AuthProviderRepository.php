<?php
namespace BoilerAppAccessControl\Repository;
class AuthProviderRepository extends \BoilerAppDb\Repository\AbstractEntityRepository{

	/**
	 * @param \BoilerAppAccessControl\Entity\AuthAccessEntity $oAuthAccessEntity
	 * @return \BoilerAppAccessControl\Entity\AuthAccessEntity
	 */
	public function create(\BoilerAppAccessControl\Entity\AuthAccessEntity $oAuthAccessEntity){
		//Set AuthAccess public key to entity
		return parent::create($oAuthAccessEntity->setAuthAccessPublicKey($this->generateAuthAccessPublicKey()));
	}

	/**
	 * @param \BoilerAppAccessControl\Entity\AuthAccessEntity $oAuthAccessEntity
	 * @return \BoilerAppAccessControl\Entity\AuthAccessEntity
	 */
	public function update(\BoilerAppAccessControl\Entity\AuthAccessEntity $oAuthAccessEntity){
		//Set new AuthAccess public key to entity for safety reasons
		return parent::update($oAuthAccessEntity->setAuthAccessPublicKey($this->generateAuthAccessPublicKey()));
	}
}