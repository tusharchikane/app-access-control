<?php
namespace BoilerAppAccessControl\Form;
class RegisterForm extends \BoilerAppDisplay\Form\AbstractForm{
	/**
	 * @var \Zend\Captcha\AbstractWord
	 */
	protected $captcha;

	/**
	 * @param \Zend\Captcha\AbstractWord $oCaptcha
	 * @return \BoilerAppAccessControl\Form\RegisterForm
	 */
	public function setCaptcha(\Zend\Captcha\AbstractWord $oCaptcha){
		$this->captcha = $oCaptcha->setName('auth_access_captcha');
		return $this;
	}

	/**
	 * @throws \LogicException
	 * @return \Zend\Captcha\AbstractWord
	 */
	public function getCaptcha(){
		if($this->captcha instanceof \Zend\Captcha\AbstractWord)return $this->captcha;
		throw new \LogicException('Captcha is undefined');
	}

	/**
	 * @see \Zend\Form\Form::prepare()
	 */
	public function prepare(){
		if($this->isPrepared)return $this;
		$oHtmlAttrEscaper = new \Zend\View\Helper\EscapeHtmlAttr();

		$this->add(array(
			'name' => 'auth_access_email_identity',
			'type' => 'email',
			'attributes' => array(
				'required' => true,
				'class' => 'required validate-email emailIsAvailable',
				'onchange' => 'oController.checkEmailIdentityAvailability(document.id(this));',
				'autocomplete' => 'off',
				'autofocus' => 'autofocus'
			),
			'options' => array(
				'label' => 'email'
			)
		))->add(array(
			'name' => 'auth_access_username_identity',
			'attributes' => array(
				'required' => true,
				'class' => 'required validate-nospace maxLength:255 usernameIsAvailable',
				'onchange' => 'oController.checkUsernameIdentityAvailability(document.id(this));',
				'autocomplete' => 'off',
			),
			'options' => array(
				'label' => 'username'
			)
		))
		->add(array(
			'name' => 'auth_access_credential',
			'attributes' => array(
				'id' => 'auth_access_credential',
				'type' => 'password',
				'required' => true,
				'class' => 'required maxLength:32',
				'autocomplete' => 'off',
				'data-behavior' => 'Form.PasswordStrength'
			),
			'options' => array(
				'label' => 'password'
			)
		))
		->add(array(
			'name' => 'auth_access_credential_confirm',
			'attributes' => array(
				'type' => 'password',
				'class' => 'required validate-match matchInput:\'auth_access_credential\' matchName:\''.$oHtmlAttrEscaper('"'.$this->getTranslator()->translate('password').'"').'\'',
				'required' => true,
				'autocomplete' => 'off'
			),
			'options' => array(
				'label' => 'confirm_password'
			)
		))
		->add(array(
			'name' => 'auth_access_captcha',
			'type' => 'Zend\Form\Element\Captcha',
			'attributes' => array(
				'required' => true,
				'placeholder' => sprintf($this->getTranslator()->translate('enter_the_x_characters'), $this->getCaptcha()->getWordlen()),
				'autocomplete' => 'off'
			),
			'options' => array(
				'label' => 'im_not_a_robot',
				'captcha' => $this->getCaptcha(),
				'class' => 'required'
			)
		))
		->add(array(
			'name' => 'submit',
			'attributes' => array(
			'type' => 'submit',
				'value' => 'register',
				'class' => 'btn-large btn-primary'
			),
			'options' => array(
            	'ignore' => true,
				'twb' => array('formAction' => true)
			)
		));
		return parent::prepare();
	}
}