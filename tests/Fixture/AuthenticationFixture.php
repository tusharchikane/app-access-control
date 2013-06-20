<?php
namespace BoilerAppAccessControlTest\Fixture;
class AuthenticationFixture extends \BoilerAppTest\Doctrine\Common\DataFixtures\AbstractFixture{
	public function load(\Doctrine\Common\Persistence\ObjectManager $oObjectManager){
		$oEncryptor = $this->getServiceLocator()->get('Encryptor');
		$oAccessControlService = $this->getServiceLocator()->get('AccessControlService');

		//Valid authentication
		$oAuthAccessEntity = new \BoilerAppAccessControl\Entity\AuthAccessEntity();
		$oObjectManager->persist($oAuthAccessEntity
			->setAuthAccessEmailIdentity('valid@test.com')
			->setAuthAccessUsernameIdentity('valid')
			->setAuthAccessCredential($oEncryptor->create(md5('valid-credential')))
			->setAuthAccessState(\BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_ACTIVE_STATE)
			//Not randomly generated key to be able to compare during testing
			->setAuthAccessPublicKey($oEncryptor->create('bc4b775da5e0d05ccbe5fa1c14'))
			->setEntityCreate(new \DateTime())
		);

		$oValidUser =  new \BoilerAppuser\Entity\UserEntity();
		$oObjectManager->persist($oValidUser
			->setUserDisplayName('Valide')
			->setEntityCreate(new \DateTime())
			->setUserAuthAccess($oAuthAccessEntity)
		);

		//Pending authentication
		$oAuthAccessEntity = new \BoilerAppAccessControl\Entity\AuthAccessEntity();
		$oObjectManager->persist($oAuthAccessEntity
			->setAuthAccessEmailIdentity('pending@test.com')
			->setAuthAccessUsernameIdentity('pending')
			//Not randomly generated key to be able to compare during testing
			->setAuthAccessCredential($oEncryptor->create(md5('pending-credential')))
			->setAuthAccessState(\BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_PENDING_STATE)
			->setAuthAccessPublicKey($oEncryptor->create('bc4b775da5e0d05ccbe5fa1c15'))
			->setEntityCreate(new \DateTime())
		);

		$oPendingUser =  new \BoilerAppuser\Entity\UserEntity();
		$oObjectManager->persist($oPendingUser
			->setUserDisplayName('Pending')
			->setEntityCreate(new \DateTime())
			->setUserAuthAccess($oAuthAccessEntity)
		);

		//Flush data
		$oObjectManager->flush();
	}
}