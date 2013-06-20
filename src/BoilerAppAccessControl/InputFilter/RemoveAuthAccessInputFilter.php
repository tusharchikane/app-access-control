<?php
namespace BoilerAppAccessControl\InputFilter;
class RemoveAuthAccessInputFilter extends \Zend\InputFilter\InputFilter{
	/**
	 * Constructor
	 */
    public function __construct(\Zend\Crypt\Password\PasswordInterface $oEncryptor, $sAuthAccessCredential){
    	$this->add(array(
			'name' => 'auth_access_credential',
			'required' => true,
    		'validators' => array(
    			array(
    				'name'=> 'BoilerAppAccessControl\Validator\AuthAccessCredentialValidator',
    				'options' => array(
    					'encryptor' => $oEncryptor,
    					'authAccessCredential' => $sAuthAccessCredential,
    				)
    			)
    		)
		));
    }
}