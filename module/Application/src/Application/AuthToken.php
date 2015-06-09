<?php
namespace Application;
use Zend\Session\Container;
use Zend\ServiceManager\ServiceManager;
use Application\BD;
use Zend\Debug;
use ZendSessionContainer;

class  AuthToken{
	static $auth;
	 static $session;
	
	private static function initialisation(){
		//var_dump(AuthToken::$auth);
		AuthToken::$session = new Container();
		var_dump(AuthToken::$session->offsetExists('tabTokens'));
		if(!AuthToken::$session->offsetExists('tabTokens')) {
			AuthToken::$session->offsetSet('tabTokens', array());
		}
		else AuthToken::$auth = AuthToken::$session->offsetGet('tabTokens');
	
	}
	
	public static function tryConnection($username,$password)
	{
		AuthToken::initialisation();
		if(AuthToken::verifUser($username, $password))
		{
			//var_dump(AuthToken::$auth);
			$tok = AuthToken::generateToken();
			$user = AuthToken::getID($username, $password);
			
			if(!isset(AuthToken::$auth->authentication[$user]))
			{
				AuthToken::$auth->authentication[$user] = $tok;
				var_dump(AuthToken::$auth->authentication);
			}
			AuthToken::$session->offsetSet('tabTokens', AuthToken::$auth);
			return(AuthToken::$auth->authentication[$user]);
		}
		else return('Pas de token enculé');
	}
	
	private static function verifUser($username,$password)
	{
		
		$adapter = BD::getAdapter();
		$sql = "SELECT * FROM MEMBRE WHERE mdp ='".$password."' AND login ='".$username."';";
			
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		$result=$resultPDO->next();
		if($result !=false & $result['login'] == $username & $result['mdp'] == $password) return true;
		return false;
	}
	private static function getID($username,$password)
	{
	
		$adapter = BD::getAdapter();
		$sql = "SELECT * FROM MEMBRE WHERE mdp ='".$password."' AND login ='".$username."';";
			
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		$result=$resultPDO->next();
		if($result !=false & $result['login'] == $username & $result['mdp'] == $password) return $result['id'];
		return 0;
	}

	private static function generateToken()
	{
		return(bin2hex(openssl_random_pseudo_bytes(16)));
	}

}

