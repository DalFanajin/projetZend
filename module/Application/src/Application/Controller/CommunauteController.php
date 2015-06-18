<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Debug;
use Application\Model\Communaute;
use Application\Model\FormatJson;
use Application\Model\AuthToken;

class CommunauteController extends AbstractRestfulController
{
	public function getAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			$params =$this->params()->fromQuery();
			if ($this->params()->fromRoute('id')){
				echo(Communaute::withId($this->params()->fromRoute('id')));
				exit;
			}
			else {
				echo(Communaute::all());
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
		echo("Méthodes disponibles: /get pour toutes les communautés, /get/id pour une communauté, /add avec nom et desc en post, /del/id pour supprimer, /modify/id avec nom et desc en post pour modifier");
		exit;
	}
	public function addAction()
	{
		if(AuthToken::verifToken( $this->request->getHeaders('Authorization')->getFieldValue()) == FormatJson::$ok)
		{
			$nom = $this->getRequest()->getPost('nom');
			$desc = $this->getRequest()->getPost('desc');
			echo(Communaute::add($nom, $desc));
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
				$desc = $this->getRequest()->getPost('desc');
				echo(Communaute::modify($this->params()->fromRoute('id'),$nom,$desc));
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
				echo(Communaute::del($this->params()->fromRoute('id')));
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