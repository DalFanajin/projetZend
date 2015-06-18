<?php
namespace Application\Model;
use Application\Model\BD;
use Application\Model\FormatJson;
class  Domaine{
	public static function all()
	{

		$adapter = BD::getAdapter();
		$sql = "SELECT * FROM DOMAINE;";

		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		$cpt=0;
		$tabJ;
		foreach($resultPDO as $res) {
				$tabJ[$cpt] = $res;
				$cpt++;
		}
		$JsonResult = json_encode($tabJ);
		
		return($JsonResult);
		
		
	}
	
	public static function withId($id)
	{
		$adapter = BD::getAdapter();
		$sql = "SELECT * FROM DOMAINE WHERE id=".$id.";";
	
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		$JsonResult= json_encode($resultPDO->next());
		return($JsonResult);
	}
	
	public static function add($nom,$text)
	{
		$adapter = BD::getAdapter();
		$sql = "INSERT INTO DOMAINE VALUES (NULL,'".$nom."',".$text."');";
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		return(FormatJson::$ok);
	}
	
	public static function del($id)
	{
		$adapter = BD::getAdapter();
		$sql = "DELETE FROM DOMAINE WHERE id =".$id.";";
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		return(FormatJson::$ok);
	}
	
	public static function modify($id,$nom,$text)
	{
		if(Communaute::del($id) == FormatJson::$ok)
		{
			$adapter = BD::getAdapter();
			$sql = "INSERT INTO DOMAINE VALUES (".$id.",'".$nom."',".$text."');";
			$statement = $adapter->createStatement($sql);
			$resultPDO = $statement->execute();
			return(FormatJson::$ok);
		}
	}
}