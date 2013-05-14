<?php
namespace BoilerAppAccessControl\Form;
class ChangeAuthAccessEmailIdentityForm extends \BoilerAppDisplay\Form\AbstractForm{

	/**
	 * Constructor
	 * @param string $sName
	 * @param array $aOptions
	 */
	public function __construct($sName = null,$aOptions = null){
		parent::__construct($sName,$aOptions);
		$this->add(array(
			'name' => 'new_auth_access_email_identity',
			'attributes' => array(
				'required' => true,
				'autofocus' => 'autofocus',
				'class' => 'required validate-email emailIsAvailable',
				'onchange' => 'oController.checkEmailIdentityAvailability(document.id(this));',
				'autocomplete' => 'off'
			),
			'options' => array(
				'label' => 'email'
			)
		))
		->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'change_email',
				'class' => 'btn-large btn-primary'
			),
			'options' => array('twb'=>array('formAction' => true))
		));
	}
}