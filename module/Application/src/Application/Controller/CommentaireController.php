<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Debug;
use Application\Model\Commentaire;
use Application\Model\AuthToken;
use Application\Model\FormatJson;

class CommentaireController extends AbstractRestfulController
{
	
	public function getAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			$params =$this->params()->fromQuery();
			if ($this->params()->fromRoute('id')){
				echo(Commentaire::withId($this->params()->fromRoute('id')));
				exit;
			}
			else {
				echo(Commentaire::all());
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
		echo("Méthodes disponibles: /get pour toutes les commentaires, /get/id pour une commentaire, /add avec nom et desc en post, /del/id pour supprimer, /modify/id avec nom et desc en post pour modifier");
		exit;
	}
	public function addAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			$text = $this->getRequest()->getPost('text');
				$date = $this->getRequest()->getPost('date');
				$idIdee = $this->getRequest()->getPost('idIdee');
				$idCommunaute = $this->getRequest()->getPost('idCommunaute');
				$idMembre = $this->getRequest()->getPost('idMembre');
			echo(Commentaire::add($text,$date,$idIdee,$idCommunaute,$idMembre));
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
				$text = $this->getRequest()->getPost('text');
				$date = $this->getRequest()->getPost('date');
				$idIdee = $this->getRequest()->getPost('idIdee');
				$idCommunaute = $this->getRequest()->getPost('idCommunaute');
				$idMembre = $this->getRequest()->getPost('idMembre');
				$nbLike = $this->getRequest()->getPost('nbLike');
				$nbDislike = $this->getRequest()->getPost('nbDislike');
				echo(Commentaire::modify($this->params()->fromRoute('id'),$text,$date,$idIdee,$idCommunaute,$idMembre,$nbLike,$nbDislike));
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
				echo(Commentaire::del($this->params()->fromRoute('id')));
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