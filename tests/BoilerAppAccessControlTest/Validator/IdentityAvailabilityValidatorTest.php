<?php
namespace BoilerAppAccessControlTest\Validator;
class IdentityAvailabilityValidatorTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase{

	/**
	 * @var \BoilerAppAccessControl\Validator\IdentityAvailabilityValidator
	 */
	protected $identityAvailabilityValidator;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
		$this->identityAvailabilityValidator = new \BoilerAppAccessControl\Validator\IdentityAvailabilityValidator();
	}

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetWrongIdentityName(){
    	$this->identityAvailabilityValidator->setIdentityName(null);
    }

    public function testGetIdentityName(){
    	$this->identityAvailabilityValidator->setIdentityName('test-identity-name');
    	$this->assertEquals('test-identity-name',$this->identityAvailabilityValidator->getIdentityName());
    }


    /**
     * @expectedException InvalidArgumentException
     */
     public function testSetWrongCurrentIdentity(){
    	$this->identityAvailabilityValidator->setCurrentIdentity(null);
    }

    public function testIsValid(){
    	//Empty value
    	$this->assertFalse($this->identityAvailabilityValidator->isValid(''));

    	//Not string value
    	$this->assertFalse($this->identityAvailabilityValidator->isValid(array('false')));

    	//Same as currently used
    	$this->identityAvailabilityValidator->setCurrentIdentity('current');
    	$this->assertFalse($this->identityAvailabilityValidator->isValid('current'));

    	//Check availablility returning false
    	$this->identityAvailabilityValidator->setCheckAvailabilityCallback(function(){return false;});
    	$this->assertFalse($this->identityAvailabilityValidator->isValid('test'));
    }
}