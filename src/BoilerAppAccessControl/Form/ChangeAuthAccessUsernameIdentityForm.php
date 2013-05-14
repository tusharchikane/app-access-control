<?php
namespace BoilerAppAccessControl\Form;
class ChangeAuthAccessUsernameIdentityForm extends \BoilerAppDisplay\Form\AbstractForm{

	/**
	 * Constructor
	 * @param string $sName
	 * @param array $aOptions
	 */
	public function __construct($sName = null,$aOptions = null){
		parent::__construct($sName,$aOptions);
		$this->add(array(
			'name' => 'new_auth_access_username_identity',
			'attributes' => array(
				'required' => true,
				'autocomplete' => 'off',
				'class' => 'required validate-nospace maxLength:255 usernameIsAvailable',
				'onchange' => 'oController.checkUsernameIdentityAvailability(document.id(this));'
			),
			'options' => array(
				'label' => 'username'
			)
		))
		->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'change_username',
				'class' => 'btn-large btn-primary'
			),
			'options' => array('twb'=>array('formAction' => true))
		));
	}
}