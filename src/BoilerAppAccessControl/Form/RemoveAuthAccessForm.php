<?php
namespace BoilerAppAccessControl\Form;
class RemoveAuthAccessForm extends \BoilerAppDisplay\Form\AbstractForm{
	/**
	 * Constructor
	 * @param string $sName
	 * @param array $aOptions
	 */
	public function __construct($sName = null,$aOptions = null){
		parent::__construct($sName,$aOptions);
		$this->add(array(
			'name' => 'auth_access_credential',
			'attributes' => array(
				'type' => 'password',
				'required' => true,
				'class' => 'required',
				'autofocus' => 'autofocus'
			),
			'options' => array(
				'label' => 'credential',
				'twb' => array(
		            'help-block' => 'please_type_in_your_credential_to_confirm'
		        )
			)
		))
		->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'remove_auth_access',
				'class' => 'btn-large btn-primary'
			),
			'options' => array(
				'ignore' => true,
				'twb' => array('formAction' => true)
			)
		));
	}
}