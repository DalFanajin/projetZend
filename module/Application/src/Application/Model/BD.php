<?php
namespace Application\Model;
use Zend\Db\Adapter\Adapter;

class BD{
	public static function getAdapter(){
		return $db = new Adapter(array(
				'driver'    => 'pdo',
        'dsn'       => 'mysql:dbname=partageidees;host=localhost',
        'username'  => 'root',
        'password'  => '',
    	'driver_options' => array(
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		)));
	}
	
}