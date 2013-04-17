<?php
namespace BoilerAppAccessControlTest\Validator;
class NoSpacesValidatorTest extends \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase{

	/**
	 * @var \BoilerAppAccessControl\Validator\NoSpacesValidator
	 */
	protected $noSpacesValidator;

	/**
	 * @see \BoilerAppTest\PHPUnit\TestCase\AbstractTestCase::setUp()
	 */
	protected function setUp(){
		parent::setUp();
		$this->noSpacesValidator = new \BoilerAppAccessControl\Validator\NoSpacesValidator();
	}

    public function testIsValid(){
    	//Not string value
    	$this->assertFalse($this->noSpacesValidator->isValid(array('false')));

		//With Spaces
    	$this->assertFalse($this->noSpacesValidator->isValid(' test '));

    	//Valid
    	$this->assertTrue($this->noSpacesValidator->isValid('test'));
    }
}