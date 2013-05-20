var BoilerAppAccessControlControllerAuthAccessIndex = {
	Extends: AccessControlIdentityAwareController,
	
	/**
	 * @return BoilerAppAccessControlControllerAuthAccess
	 */
	changeAuthAccessEmailIdentity : function(){
		new Modal.Popup({
			'title':this.translate('change_email'),
			'url':this.url('AccessControl/AuthAccess/ChangeEmailIdentity')
		});
		return this;
	},
	
	/**
	 * @param string sEmailIdentity
	 * @return BoilerAppAccessControlControllerAuthAccess
	 */
	setAuthAccessEmailIdentity : function(sEmailIdentity){
		var eAuthAccessEmailIdentity = document.id('authaccess_email_identity');
		if(eAuthAccessEmailIdentity == null)throw 'Authaccess email identity element is undefined';
		eAuthAccessEmailIdentity.set('html',sEmailIdentity);
		return this;
	},
	
	/**
	 * @return BoilerAppAccessControlControllerAuthAccess
	 */
	changeAuthAccessUsernameIdentity : function(){
		new Modal.Popup({
			'title':this.translate('change_username'),
			'url':this.url('AccessControl/AuthAccess/ChangeUsernameIdentity')
		});
		return this;
	},
	
	/**
	 * @param string sUsernameIdentity
	 * @return BoilerAppAccessControlControllerAuthAccess
	 */
	setAuthAccessUsernameIdentity : function(sUsernameIdentity){
		var eAuthAccessUsernameIdentity = document.id('authaccess_username_identity');
		if(eAuthAccessUsernameIdentity == null)throw 'Authaccess username identity element is undefined';
		eAuthAccessUsernameIdentity.set('html',sUsernameIdentity);
		return this;
	},
	
	/**
	 * @return BoilerAppAccessControlControllerAuthAccess
	 */
	changeAuthAccessCredential : function(){
		new Modal.Popup({
			'title':this.translate('change_credential'),
			'url':this.url('AccessControl/AuthAccess/ChangeCredential')
		});
		return this;
	}
};
BoilerAppAccessControlControllerAuthAccess = new Class(BoilerAppAccessControlControllerAuthAccess);