<?php
include ('lib/indenter.php');
function connect_db($bd, $host="localhost", $user="root", $password="root", $port=3306)
{	
	try{
	$connexion = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$bd,
								$user,
								$password);
	return $connexion;
	}
	catch(PDOException $e){
		//$logger = Logger::getLogger('test');
		//$logger->error("Erreur: ".$e->getMessage().". N°: ".$e->getCode());
		echo $e;
		return false;
	}	
}

function getTableNames($connexion){
	$tables = array();
	$req = 'SHOW TABLES';
	$requete = $connexion->prepare($req);
	$requete->execute();
	while($ligne = $requete->fetch())
	{
		$tables[]=$ligne[0];
	}
	return $tables;
}

function getAttributes($connexion, $table){
	// EXTRACTION DES CLES
	$req = 'SHOW KEYS FROM '.$table." WHERE Key_name = 'PRIMARY'";
	$requete = $connexion->prepare($req);
	$requete->execute();
	$keys = array();
	while($ligne = $requete->fetch())
	{
		$keys[]=$ligne["Column_name"];
	}
	// EXTRACTION NOM ATTRIBUTS
	$req = 'SHOW COLUMNS FROM '.$table;
	$requete = $connexion->prepare($req);
	$requete->execute();
	$attributes = array();
	while($ligne = $requete->fetch())
	{
		$attributes[]=$ligne[0];
	}
	// SUPPRESSION DES CLES DANS LES ATTRIBUTS
	foreach($keys as $key){
	$i=0;
		foreach($attributes as $attr)
		{
			if($attr == $key)
			{
				unset($attributes[$i]);
				$attributes = array_values($attributes);	
			}
			$i++;
		}
	}
	// ON RETOURNE UN TABLEAU 2 DIMENSIONS
	// $tab["keys"]["nomKey"] et $tab["attributes"]["nomAttr"]
	return array("keys"=>$keys, "attr"=>$attributes);
}

function accessorFormatString($string)
{
	$string[0]=strtoupper($string[0]);
	while($pos=strpos($string, '_'))
	{
	$string=substr_replace($string, "", $pos, 1);
	$string[$pos] = strtoupper($string[$pos]);
		//$string[$pos] = "$";
	//$string=str_replace("$","",$string);
	}
	return $string;	
}
?>