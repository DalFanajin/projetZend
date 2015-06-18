<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Debug;
use Application\Model\Domaine;
use Application\Model\AuthToken;
use Application\Model\FormatJson;

class DomaineController extends AbstractRestfulController
{
	
	public function getAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			$params =$this->params()->fromQuery();
			if ($this->params()->fromRoute('id')){
				echo(Domaine::withId($this->params()->fromRoute('id')));
				exit;
			}
			else {
				echo(Domaine::all());
				exit;
			}
			echo(FormatJson::$erreur);
			exit;
		}
		echo FormatJson::$erreur;
		exit;
		
	}
	
	public function getList()
	{
		echo("Méthodes disponibles: /get pour toutes les domaines, /get/id pour une domaine, /add avec nom et desc en post, /del/id pour supprimer, /modify/id avec nom et desc en post pour modifier");
		exit;
	}
	public function addAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			$nom = $this->getRequest()->getPost('nom');
			$text = $this->getRequest()->getPost('text');
			echo(Domaine::add($nom, $desc));
			exit;
		}
		echo FormatJson::$erreur;
		exit;
		
	}
	
	public function modifyAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			$params =$this->params()->fromQuery();
			if ($this->params()->fromRoute('id')){
				$nom = $this->getRequest()->getPost('nom');
				$text = $this->getRequest()->getPost('text');
				echo(Domaine::modify($this->params()->fromRoute('id'),$nom,$text));
				exit;
			}
			echo(FormatJson::$erreur);
			exit;
		}
		echo FormatJson::$erreur;
		exit;
		
	}
	
	public function delAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			
			$params =$this->params()->fromQuery();
			if ($this->params()->fromRoute('id')){
				echo(Domaine::del($this->params()->fromRoute('id')));
				exit;
			}
			echo(FormatJson::$erreur);
			exit;
		}
		echo FormatJson::$erreur;
		exit;
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