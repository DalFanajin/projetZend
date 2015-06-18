<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\Debug;
use Application\Model\AuthToken;
use Zend\Http;

use Application\Model\FormatJson;
class AuthController extends AbstractRestfulController
{
	public function getAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			echo(AuthToken::withId($this->request->getHeaders('Authorization')->getFieldValue()));
			exit;
		}
		echo FormatJson::$erreur;
		exit;
	
	}
	
	public function iCanCallAction()
	{
		echo ("icancall");
		exit;
	}
	
	
	public function authAction()
	{
		
		$user = $this->getRequest()->getPost('username');
		$mdp = $this->getRequest()->getPost('password');
		
 		
		$token = AuthToken::tryConnection($user,$mdp);
		echo ($token);
		exit;
	}
	public function getList()
	{
		$response = $this->getResponseWithHeader()
		->setContent( __METHOD__.' get the list of data');
		return $response;
	}
	// configure response
	public function getResponseWithHeader()
	{
		$response = $this->getResponse();
		$response->getHeaders()
		//make can accessed by *
		->addHeaderLine('Access-Control-Allow-Origin','*')
		//set allow methods
		->addHeaderLine('Access-Control-Allow-Methods','POST PUT DELETE GET');
			
		return $response;
	}
}