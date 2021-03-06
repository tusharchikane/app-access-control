<?php
namespace BoilerAppAccessControl\InputFilter;
class RegisterInputFilter extends \Zend\InputFilter\InputFilter{
	/**
	 * Constructor
	 * @param \BoilerAppAccessControl\Repository\AuthAccessRepository $oAuthAccessRepository
	 * @param \Zend\I18n\Translator\Translator $oTranslator
	 */
    public function __construct(\BoilerAppAccessControl\Repository\AuthAccessRepository $oAuthAccessRepository,\Zend\I18n\Translator\Translator $oTranslator){
    	$this->add(array(
			'name' => 'auth_access_email_identity',
			'required' => true,
			'filters' => array(array('name' => 'StringTrim')),
			'validators' => array(
				array('name'=> 'EmailAddress','break_chain_on_failure' => true),
				array(
					'name'=> 'BoilerAppAccessControl\Validator\IdentityAvailabilityValidator',
					'options' => array(
						'identityName' => $oTranslator->translate('the_email'),
						'checkAvailabilityCallback' => array($oAuthAccessRepository, 'isEmailIdentityAvailable')
					)
				)
			)
		))
		->add(array(
			'name' => 'auth_access_username_identity',
			'required' => true,
			'filters' => array(array('name' => 'StringTrim')),
			'validators' => array(
				array('name'=> 'BoilerAppAccessControl\Validator\NoSpacesValidator','break_chain_on_failure' => true),
				array(
					'name'=> 'stringLength',
					'options' => array('max' => 255),
					'break_chain_on_failure' => true
				),
				array(
					'name'=> 'BoilerAppAccessControl\Validator\IdentityAvailabilityValidator',
					'options' => array(
						'identityName' => $oTranslator->translate('the_username'),
						'checkAvailabilityCallback' => array($oAuthAccessRepository, 'isUsernameIdentityAvailable')
					)
				)
			)
		))->add(array(
			'name' => 'auth_access_credential',
			'required' => true
		))->add(array(
			'name' => 'auth_access_credential_confirm',
			'required' => true,
			'validators' => array(array('name'=> 'Identical','options' => array('token'=>'auth_access_credential')))
		));
    }
}