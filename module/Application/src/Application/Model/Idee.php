<?php
namespace Application\Model;
use Application\Model\BD;
use Application\Model\FormatJson;
class  Idee{
	public static function all()
	{

		$adapter = BD::getAdapter();
		$sql = "SELECT * FROM IDEE;";

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
		$sql = "SELECT * FROM IDEE WHERE id=".$id.";";
	
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		$JsonResult= json_encode($resultPDO->next());
		return($JsonResult);
	}
	
	public static function add($titre, $texte,$pdf,$date,$idCommunaute,$idMembre,$idDomaine,$idCommunauteAssocie)
	{
		$adapter = BD::getAdapter();
		$sql = "INSERT INTO IDEE VALUES (NULL,'".$titre."','".$texte."','".$pdf."',0,0,'".$date."','".$idDomaine."','".$idMembre."','".$idCommunauteAssocie."','".$idCommunaute."');";
		
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		return(FormatJson::$ok);
	}
	
	public static function del($id)
	{
		$adapter = BD::getAdapter();
		$sql = "DELETE FROM IDEE WHERE id =".$id.";";
		$statement = $adapter->createStatement($sql);
		$resultPDO = $statement->execute();
		return(FormatJson::$ok);
	}
	
	public static function modify($id,$titre, $texte,$pdf,$date,$idCommunaute,$idMembre,$idDomaine,$idCommunauteAssocie,$nbLike,$nbDislike)
	{
		if(Communaute::del($id) == FormatJson::$ok)
		{
			$adapter = BD::getAdapter();
			$sql = "INSERT INTO IDEE VALUES (".$id.",'".$titre."','".$texte."','".$pdf."','".$nbLike."','".$nbDislike."','".$date."','".$idDomaine."','".$idMembre."','".$idCommunauteAssocie."','".$idCommunaute."');";
			$statement = $adapter->createStatement($sql);
			$resultPDO = $statement->execute();
			return(FormatJson::$ok);
		}
	}
}