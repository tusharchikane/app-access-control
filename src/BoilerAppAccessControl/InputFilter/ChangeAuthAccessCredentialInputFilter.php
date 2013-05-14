<?php
namespace BoilerAppAccessControl\InputFilter;
class ChangeAuthAccessCredentialInputFilter extends \Zend\InputFilter\InputFilter{
	/**
	 * Constructor
	 */
    public function __construct(){
    	$this->add(array(
    		'name' => 'new_auth_access_credential',
    		'required' => true
    	))->add(array(
    		'name' => 'auth_access_credential_confirm',
    		'required' => true,
    		'validators' => array(array('name'=> 'Identical','options' => array('token'=>'new_auth_access_credential')))
    	));
    }
}