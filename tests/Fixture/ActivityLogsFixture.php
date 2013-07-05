<?php
namespace BoilerAppAccessControlTest\Fixture;
class ActivityLogsFixture extends \BoilerAppAccessControlTest\Fixture\AuthenticationFixture{
	public function load(\Doctrine\Common\Persistence\ObjectManager $oObjectManager){
		parent::load($oObjectManager);
		$oAuthAccessEntity = $oObjectManager->find('\BoilerAppAccessControl\Entity\AuthAccessEntity', 1);
		$oDateTime = new \DateTime();

		$aUserAgents = array(
			'Mozilla/5.0 (Linux; Android 4.0.4; Desire HD Build/IMM76D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19',
			'NokiaN91-1/3.0 (1.00.001.15) SymbianOS/9.1 Series60/3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.50',
			'Mozilla/5.0 (iPod; U; CPU iPhone OS 2_1 like Mac OS X; fr-fr) AppleWebKit/525.18.1 (KHTML, like Gecko) Version/3.1.1 Mobile/5F137 Safari/525.20'
		);

		//Create logs
		foreach(array(
			array('log_action_name' => 'index','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.1', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '1'),
			array('log_action_name' => 'index2','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.1', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '1'),
			array('log_action_name' => 'index','log_controller_name' => 'IndexController','log_ip_address' => null, 'log_auth_access' => null, 'log_session_id' => null),
			array('log_action_name' => 'index2','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.2', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '2'),
			array('log_action_name' => 'index','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.3', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '3'),
			array('log_action_name' => 'index2','log_controller_name' => 'IndexController','log_ip_address' => null, 'log_auth_access' => null, 'log_session_id' => null),
			array('log_action_name' => 'index','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.1', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '2'),
			array('log_action_name' => 'index2','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.1', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '3'),
			array('log_action_name' => 'index','log_controller_name' => 'IndexController','log_ip_address' => null, 'log_auth_access' => null, 'log_session_id' => null),
			array('log_action_name' => 'index2','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.1', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '4'),
			array('log_action_name' => 'index','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.5', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '5'),
			array('log_action_name' => 'index2','log_controller_name' => 'IndexController','log_ip_address' => null, 'log_auth_access' => null, 'log_session_id' => null),
			array('log_action_name' => 'index','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.1', 'log_auth_access' => null, 'log_session_id' => null),
			array('log_action_name' => 'index2','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.5', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '5'),
			array('log_action_name' => 'index','log_controller_name' => 'IndexController','log_ip_address' => '127.1.0.6', 'log_auth_access' => $oAuthAccessEntity, 'log_session_id' => '6'),
			array('log_action_name' => 'index2','log_controller_name' => 'IndexController','log_ip_address' => null, 'log_auth_access' => null, 'log_session_id' => null)
		) as $aInfosLog){
			$oLogEntity = new \BoilerAppLogger\Entity\LogEntity();
			if($aInfosLog['log_auth_access'])$oLogEntity->setLogAuthAccess($aInfosLog['log_auth_access']);
			$oDateTime->sub(\DateInterval::createFromDateString('1 hour'));
			$oTmpDateTime = clone $oDateTime;

			$oObjectManager->persist($oLogEntity
				->setLogActionName($aInfosLog['log_action_name'])
				->setLogControllerName($aInfosLog['log_controller_name'])
				->setLogIPAddress($aInfosLog['log_ip_address'])
				->setLogRequestMethod(\Zend\Http\Request::METHOD_GET)
				->setLogRequestHeaders(\Zend\Http\Headers::fromString('User-Agent: '.$aUserAgents[array_rand($aUserAgents)]))
				->setLogRequestUri('/')
				->setEntityCreate($oTmpDateTime)
				->setLogSessionId($aInfosLog['log_session_id'])
			);
		}

		//Flush data
		$oObjectManager->flush();
	}
}