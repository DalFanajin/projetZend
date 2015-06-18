<?php
namespace Application\Model;
use Application\Model\BD;
use Application\Model\FormatJson;
class  Commentaire{
	public static function all()
	{

		$adapter = BD::getAdapter();
		$sql = "SELECT * FROM COMMENTAIRE;";

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
		$sql = "SELECT * FROM COMMENTAIRE WHERE id=".$id.";";
	
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		$JsonResult= json_encode($resultPDO->next());
		return($JsonResult);
	}
	
	public static function add($text,$date,$idIdee,$idCommunaute,$idMembre)
	{
		$adapter = BD::getAdapter();
		$sql = "INSERT INTO COMMENTAIRE VALUES (NULL,'".$text."', 0, 0, '".$date."', '".$idIdee."', '".$idCommunaute."', '".$idMembre."');";
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		return(FormatJson::$ok);
	}
	
	public static function del($id)
	{
		$adapter = BD::getAdapter();
		$sql = "DELETE FROM COMMENTAIRE WHERE id =".$id.";";
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		return(FormatJson::$ok);
	}
	
	public static function modify($id,$text,$date,$idIdee,$idCommunaute,$idMembre,$nbLike,$nbDislike)
	{
		if(Communaute::del($id) == FormatJson::$ok)
		{
			$adapter = BD::getAdapter();
			$sql = "INSERT INTO COMMENTAIRE VALUES (".$id.",'".$text."','".$nbLike."','".$nbDislike."', '".$date."', '".$idIdee."', '".$idCommunaute."', '".$idMembre."');";
			$statement = $adapter->createStatement($sql);
			$resultPDO = $statement->execute();
			return(FormatJson::$ok);
		}
	}
}