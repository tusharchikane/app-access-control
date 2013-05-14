<?php
namespace BoilerAppAccessControl\Form;
class ChangeAuthAccessCredentialForm extends \BoilerAppDisplay\Form\AbstractForm{

	/**
	 * @see \Zend\Form\Form::prepare()
	 */
	public function prepare(){
		if($this->isPrepared)return $this;
		$oHtmlAttrEscaper = new \Zend\View\Helper\EscapeHtmlAttr();
		$this->add(array(
			'name' => 'new_auth_access_credential',
			'attributes' => array(
				'id' => 'auth_access_credential',
				'type' => 'password',
				'required' => true,
				'class' => 'required maxLength:32',
				'autocomplete' => 'off',
				'data-behavior' => 'Form.PasswordStrength'
			),
			'options' => array(
				'label' => 'credential'
			)
		))
		->add(array(
			'name' => 'auth_access_credential_confirm',
			'attributes' => array(
				'type' => 'password',
				'class' => 'required validate-match matchInput:\'new_auth_access_credential\' matchName:\''.$oHtmlAttrEscaper('"'.$this->getTranslator()->translate('credential').'"').'\'',
				'required' => true,
				'autocomplete' => 'off'
			),
			'options' => array(
				'label' => 'confirm_credential'
			)
		))
		->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'change_credential',
				'class' => 'btn-large btn-primary'
			),
			'options' => array('twb' => array('formAction' => true))
		));
		return parent::prepare();
	}
}