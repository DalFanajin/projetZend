<?php
namespace Application\Model;
use Zend\Session\Container;
use Zend\ServiceManager\ServiceManager;
use Application\Model\BD;
use Zend\Debug;
use ZendSessionContainer;

class  AuthToken{
	static $auth;
	 static $session;
	 
	 public static function withId($tok)
	 {
	 	AuthToken::initialisation();
	 	$adapter = BD::getAdapter();
	 	$sql = "SELECT * FROM MEMBRE WHERE id=".array_search($tok,AuthToken::$auth).";";
	 
	 	$statement = $adapter->createStatement($sql);
	 	$resultPDO = $statement->execute();
	 	$JsonResult= json_encode($resultPDO->next());
	 	return($JsonResult);
	 }
	 
	 public static  function verifToken($tok)
	 {
	 	AuthToken::initialisation();
	 	if(!in_array($tok,AuthToken::$auth))
	 	{
	 		echo(FormatJson::$erreur);
	 		exit;
	 	}
	 	return FormatJson::$ok;
	 }
	 
	private static function initialisation(){
		AuthToken::$session = new Container();
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
			
			$tok = AuthToken::generateToken();
			$user = AuthToken::getID($username, $password);
			
			if(!isset(AuthToken::$auth[$user]))
			{
				AuthToken::$auth[$user] = $tok;
			}
			AuthToken::$session->offsetSet('tabTokens', AuthToken::$auth);
			var_dump(AuthToken::$auth);
			return(AuthToken::$auth[$user]);
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

