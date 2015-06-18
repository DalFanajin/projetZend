<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Debug;
use Application\Model\Idee;
use Application\Model\AuthToken;
use Application\Model\FormatJson;

class IdeeController extends AbstractRestfulController
{
	
	public function getAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			$params =$this->params()->fromQuery();
			if ($this->params()->fromRoute('id')){
				echo(Idee::withId($this->params()->fromRoute('id')));
				exit;
			}
			else {
				echo(Idee::all());
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
		echo("Méthodes disponibles: /get pour toutes les idees, /get/id pour une idee, /add avec nom et desc en post, /del/id pour supprimer, /modify/id avec nom et desc en post pour modifier");
		exit;
	}
	public function addAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			$titre = $this->getRequest()->getPost('titre');
			$texte = $this->getRequest()->getPost('texte');
			$pdf = $this->getRequest()->getPost('pdf');
			$date = $this->getRequest()->getPost('date');
			$idCommunaute = $this->getRequest()->getPost('idCommunaute');
			$idMembre = $this->getRequest()->getPost('idMembre');
			$idDomaine = $this->getRequest()->getPost('idDomaine');
			$idCommunauteAssocie = $this->getRequest()->getPost('idCommunauteAssocie');
			echo(Idee::add($titre,$texte,$pdf,$date,$idCommunaute,$idMembre,$idDomaine,$idCommunauteAssocie));
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
				$titre = $this->getRequest()->getPost('titre');
				$texte = $this->getRequest()->getPost('texte');
				$pdf = $this->getRequest()->getPost('pdf');
				$date = $this->getRequest()->getPost('date');
				$idCommunaute = $this->getRequest()->getPost('idCommunaute');
				$idMembre = $this->getRequest()->getPost('idMembre');
				$idDomaine = $this->getRequest()->getPost('idDomaine');
				$idCommunauteAssocie = $this->getRequest()->getPost('idCommunauteAssocie');
				$nbLike = $this->getRequest()->getPost('nbLike');
				$nbDislike = $this->getRequest()->getPost('nbDislike');
				echo(Idee::modify($this->params()->fromRoute('id'),$titre, $texte,$pdf,$date,$idCommunaute,$idMembre,$idDomaine,$idCommunauteAssocie,$nbLike,$nbDislike));
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
				echo(Idee::del($this->params()->fromRoute('id')));
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