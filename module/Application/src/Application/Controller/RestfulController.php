<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Debug;

class RestfulController extends AbstractRestfulController
{


public function getAction()
	{
		$params =$this->params()->fromQuery();
		if ($this->params()->fromRoute('id')){
			echo ("L'idée n°" .$this->params()->fromRoute('id'));
		}
		else {
			echo ("toutes les idées");
		}
		exit;
	}
	
	public function getList()
	{
		$response = $this->getResponseWithHeader()
		->setContent( __METHOD__.' get the list of data');
		return $response;
	}
	public function bonjourAction()
	{
		echo ("bonjour");
		exit;
	}
	 
	public function create($data)
	{
		$response = $this->getResponseWithHeader()
		->setContent( __METHOD__.' create new item of data :
                                                    <b>'.$data['name'].'</b>');
		return $response;
	}
	 
	public function update($id, $data)
	{
		$response = $this->getResponseWithHeader()
		->setContent(__METHOD__.' update current data with id =  '.$id.
				' with data of name is '.$data['name']) ;
		return $response;
	}
	 
	public function delete($id)
	{
		$response = $this->getResponseWithHeader()
		->setContent(__METHOD__.' delete current data with id =  '.$id) ;
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