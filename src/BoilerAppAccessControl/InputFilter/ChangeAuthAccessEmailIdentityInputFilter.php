<?php
namespace BoilerAppAccessControl\InputFilter;
class ChangeAuthAccessEmailIdentityInputFilter extends \Zend\InputFilter\InputFilter{
	/**
	 * Constructor
	 * @param \BoilerAppAccessControl\Repository\AuthAccessRepository $oAuthAccessRepository
	 * @param \Zend\I18n\Translator\Translator $oTranslator
	 */
    public function __construct(\BoilerAppAccessControl\Repository\AuthAccessRepository $oAuthAccessRepository,\Zend\I18n\Translator\Translator $oTranslator){
    	$this->add(array(
			'name' => 'new_auth_access_email_identity',
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
		));
    }
}