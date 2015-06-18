<?php
namespace Application\Model;
use Application\Model\BD;
use Application\Model\FormatJson;
class  Communaute{
	
	public static function all()
	{

		$adapter = BD::getAdapter();
		$sql = "SELECT * FROM COMMUNAUTE;";

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
		$sql = "SELECT * FROM COMMUNAUTE WHERE id=".$id.";";
	
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		$JsonResult= json_encode($resultPDO->next());
		return($JsonResult);
	}
	
	public static function add($nom,$desc)
	{
		$adapter = BD::getAdapter();
		$sql = "INSERT INTO COMMUNAUTE VALUES (NULL,'".$nom."','".$desc."');";
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		return(FormatJson::$ok);
	}
	
	public static function del($id)
	{
		$adapter = BD::getAdapter();
		$sql = "DELETE FROM COMMUNAUTE WHERE id =".$id.";";
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		return(FormatJson::$ok);
	}
	
	public static function modify($id,$nom,$desc)
	{
		if(Communaute::del($id) == FormatJson::$ok)
		{
			$adapter = BD::getAdapter();
			$sql = "INSERT INTO COMMUNAUTE VALUES (".$id.",'".$nom."','".$desc."');";
			$statement = $adapter->createStatement($sql);
			$resultPDO = $statement->execute();
			return(FormatJson::$ok);
		}
	}
}