<?php
namespace BoilerAppAccessControlTest\Fixture;
class AuthenticationFixture extends \BoilerAppTest\Doctrine\Common\DataFixtures\AbstractFixture{
	public function load(\Doctrine\Common\Persistence\ObjectManager $oObjectManager){
		$oBCrypt = new \Zend\Crypt\Password\Bcrypt();
		$oAccessControlService = $this->getServiceLocator()->get('AccessControlService');

		//Valid authentication
		$oValidUser =  new \BoilerAppuser\Entity\UserEntity();
		$oObjectManager->persist($oValidUser
			->setUserDisplayName('Valid')
			->setEntityCreate(new \DateTime())
		);

		$oAuthAccessEntity = new \BoilerAppAccessControl\Entity\AuthAccessEntity();
		$oObjectManager->persist($oAuthAccessEntity
			->setAuthAccessEmailIdentity('valid@test.com')
			->setAuthAccessUsernameIdentity('valid')
			->setAuthAccessCredential($oBCrypt->create(md5('valid-credential')))
			->setAuthAccessState(\BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_ACTIVE_STATE)
			->setAuthAccessUser($oValidUser)
			//Not randomly generated key to be able to compare during testing
			->setAuthAccessPublicKey($oBCrypt->create('bc4b775da5e0d05ccbe5fa1c14'))
			->setEntityCreate(new \DateTime())
		);

		//Pending authentication
		$oPendingUser =  new \BoilerAppuser\Entity\UserEntity();
		$oObjectManager->persist($oPendingUser
			->setUserDisplayName('Pending')
			->setEntityCreate(new \DateTime())
		);

		$oAuthAccessEntity = new \BoilerAppAccessControl\Entity\AuthAccessEntity();
		$oObjectManager->persist($oAuthAccessEntity
			->setAuthAccessEmailIdentity('pending@test.com')
			->setAuthAccessUsernameIdentity('pending')
			->setAuthAccessCredential($oBCrypt->create(md5('pending-credential')))
			->setAuthAccessState(\BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_PENDING_STATE)
			->setAuthAccessUser($oPendingUser)
			->setAuthAccessPublicKey($oBCrypt->create($oAccessControlService->generateAuthAccessPublicKey()))
			->setEntityCreate(new \DateTime())
		);

		//Flush data
		$oObjectManager->flush();
	}
}