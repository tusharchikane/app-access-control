<?php
namespace BoilerAppAccessControl\Doctrine\DBAL\Types;
class AuthAccessStateEnumType extends \BoilerAppDb\Doctrine\DBAL\Types\AbstractEnumType{
	/**
	 * @var string
	 */
	protected $name = 'authaccessstateenum';

	/**
	 * @var array
	 */
    protected $values = array(
    	\BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_PENDING_STATE,
    	\BoilerAppAccessControl\Repository\AuthAccessRepository::AUTH_ACCESS_ACTIVE_STATE
    );
}