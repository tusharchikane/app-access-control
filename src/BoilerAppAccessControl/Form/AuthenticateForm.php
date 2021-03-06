<?php
namespace BoilerAppAccessControl\Form;
class AuthenticateForm extends \BoilerAppDisplay\Form\AbstractForm{

	/**
	 * Constructor
	 * @param string $sName
	 * @param array $aOptions
	 */
	public function __construct($sName = null,$aOptions = null){
		parent::__construct($sName,$aOptions);
		$this->add(array(
			'name' => 'auth_access_identity',
			'attributes' => array(
				'placeholder' => 'email_or_username',
				'required' => true,
				'class' => 'required input-xlarge',
				'autofocus' => 'autofocus'
			),
			'options'=>array('twb' => array('prepend' => array('type' => 'icon','icon' => 'icon-user')))
		))
		->add(array(
			'name' => 'auth_access_credential',
			'attributes' => array(
				'type'  => 'password',
				'placeholder' => 'credential',
				'required' => true,
				'class' => 'required input-xlarge'
			),
			'options'=>array('twb' => array('prepend' => array('type' => 'icon','icon' => 'icon-lock')))
		))
		->add(array(
			'name' => 'auth_access_remember',
			'attributes' => array(
				'label' => 'remember_me',
				'use_hidden_element' => false,
				'type'  => 'checkbox',
				'class' => 'input-xlarge'
			)
		))

		->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'sign_in',
				'class' => 'btn-large btn-primary',
				'disabled' => true
			),
			'options' => array(
				'ignore' => true,
				'twb' => array('formAction' => true)
			)
		));
	}
}