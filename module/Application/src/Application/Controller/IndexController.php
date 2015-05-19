<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;
// use Zend\Db\Adapter\Adapter;
// use Zend\Db\Sql\Sql;
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$adapter = $this->getServiceLocator()->get('db');
    	//Debug::dump($adapter);
    	$sql = 'INSERT INTO TESTZEND VALUES ("CA FONCTIONNE BIEEEEN",":D");';
    	$statement = $adapter->createStatement($sql);
    	$result = $statement->execute();
    	
        return new ViewModel();
    }
    
}
