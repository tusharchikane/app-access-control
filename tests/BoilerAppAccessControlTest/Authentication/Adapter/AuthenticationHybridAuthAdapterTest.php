<?php
namespace BoilerAppAccessControlTest\Authentication\Adapter;
class AuthenticationHybridAuthAdapterTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase{

	/**
	 * @var \BoilerAppAccessControl\Authentication\Adapter\AuthenticationHybridAuthAdapter
	 */
	protected $authenticationHybridAuthAdapter;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractDoctrineTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
	}
}