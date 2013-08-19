<?php
namespace BoilerAppAccessControlTest\Authentication;
class SessionManager extends \Zend\Session\SessionManager{

	/**
	 * Regenerate id
	 * Regenerate the session ID, using session save handler's
	 * native ID generation Can safely be called in the middle of a session.
	 * @param  bool $deleteOldSession
	 * @return \BoilerAppAccessControlTest\Authentication\SessionManager
	 */
	public function regenerateId($deleteOldSession = true)
	{
		return $this;
	}
}