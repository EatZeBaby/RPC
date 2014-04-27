<?php
function makeClass($name){
	global $connexion;
	$attributes = getAttributes($connexion, $name);
	$class="&lt;?php
class ".strtoupper($name[0]).strtolower(substr($name, 1)).'{
';
	$class .= makeAttList($attributes);	
	$class .= makeConstructor($attributes);
	$class .= makeLoadDb($attributes, $name);
	$class .= makeAddDb($attributes, $name);
	$class .= makeEditDb($attributes, $name);
	$class .= makeDeleteDb($attributes, $name);
	$class .= makeEditObject($attributes);
	$class .= makeGetters($attributes);
	$class .= makeSetters($attributes);
	$class .= makeInputs($attributes);
	$class .= "}
?>";
	return $class;	
}

// SETTER
function makeSetters($attributeList){
	$string ='
	// SETTERS
';
	foreach($attributeList["keys"] as $key)
		$string.= '	public function set'.accessorFormatString($key).'($a){$this->'.$key.'=secure($a);}
';
	foreach($attributeList["attr"] as $att)
		$string.= '	public function set'.accessorFormatString($att).'($a){$this->'.$att.'=secure($a);}
';
		return $string;
}

// GETTERS
function makeGetters($attributeList){
	$string ='
	// GETTERS
';
	foreach($attributeList["keys"] as $key)
	{ 
		$date = strpos(strtoupper($key), "DATE")!== false;
		$string.= '	public function get'.accessorFormatString($key).'('.($date?'$format=""':'').'){'.($date?'if($format!="")return date($format, strtotime($this->'.$key.'));':'').'return affiche($this->'.$key.');}
';	
	}
	foreach($attributeList["attr"] as $att){
		$date = strpos(strtoupper($att), "DATE")!== false;
		$string.= '	public function get'.accessorFormatString($att).'('.($date?'$format=""':'').'){'.($date?'if($format!="")return date($format, strtotime($this->'.$att.'));':'').'return affiche($this->'.$att.');}
';
	}
		return $string;
}
// INPUTS
function makeInputs($attributeList){
	$string ='
	// INPUTS
';
	foreach($attributeList["keys"] as $key)
	{
		$string.= '	public function get'.accessorFormatString($key).'Input($attr){if(empty($attr)){$attr=array();$attr["type"]="text";}';
		$string.='$attributs = "";';
		$string.='foreach($attr as $key => $val)$attributs .= $key.\'="\'.$val.\'" \';';
		$string.='return \'&lt;input type="hidden" name="'.$key.'" \'.$attributs.\' value="\'.$this->'.$key.'.\'" /&gt;\';}
';
	}
	foreach($attributeList["attr"] as $att)
	{
		$string.= '	public function get'.accessorFormatString($att).'Input($attr){if(empty($attr)){$attr=array();$attr["type"]="text";}';
		$string.='$attributs = "";';
		$string.='foreach($attr as $key => $val)$attributs .= $key.\'="\'.$val.\'" \';';
		$string.='return \'&lt;input name="'.$att.'" \'.$attributs.\' value="\'.$this->'.$att.'.\'" /&gt;\';}
';
	}
		return $string;
}

// EDIT DB
function makeEditDb($attributeList, $tableName){
	$edit_db='
	// METHODE EDIT DB
	public function edit_db(){
		';
	$edit_db.='global $connexion;
';
	$edit_db.=
'		$req = "UPDATE '.$tableName.' SET ';
	$i = 0;
	foreach($attributeList["attr"] as $att)
	{
		if($i++ != 0)$edit_db.=', ';
		$edit_db.=$att.'=:'.$att;
	}
	$edit_db .= ' WHERE ';
	$i = 0;
	foreach($attributeList["keys"] as $key)
	{
		if($i++ != 0)$edit_db.=' AND ';
		$edit_db.=$key.'=:'.$key;
	}
	$edit_db .='";
		$requete = $connexion->prepare($req);
		$tab=array(';
	$i = 0;
	foreach($attributeList["keys"] as $key)
	{
		if($i++ != 0)$edit_db.=', ';
		$edit_db.='"'.$key.'"=>$this->'.$key;
	}
	foreach($attributeList["attr"] as $att)
	{
		if($i++ != 0)$edit_db.=', ';
		$edit_db.='"'.$att.'"=>$this->'.$att;
	}
	$edit_db.=');';
	$edit_db.='
		if($requete->execute($tab)){
			$requete->CloseCursor();
			return true;
		}
		else
			return false;
	}
	';
	return $edit_db;	
}
// DEL DB
function makeDeleteDb($attributeList, $tableName){
	$add_db='
	// METHODE DELETE DB
	public function del_db(){
		';
	$add_db.='global $connexion;
';
	$add_db.=
'		$req = "DELETE FROM '.$tableName.' WHERE ';
	$i = 0;
	foreach($attributeList["keys"] as $key)
	{
		if($i++ != 0)$add_db.=' AND ';
		$add_db.=$key.'=:'.$key;
	}
	$add_db.='";
		$requete = $connexion->prepare($req);
		$tab=array(';
	$i = 0;
	foreach($attributeList["keys"] as $key)
	{
		if($i++ != 0)$add_db.=', ';
		$add_db.='"'.$key.'"=>$this->'.$key;
	}
	$add_db.=');';
	$add_db.='
		if($requete->execute($tab)){
			$requete->CloseCursor();
			return true;
		}
		else
			return false;
	}
	';
	return $add_db;	
}

// ADD DB
function makeAddDb($attributeList, $tableName){
	$add_db='
	// METHODE ADD DB
	public function add_db(){
		';
	$add_db.='global $connexion;
';
	$add_db.=
	'		$req = "INSERT INTO '.$tableName.' (';
	$i = 0;
	// COMMENT ON FAIT S'IL Y A DEUX CLEFS PRIMAIRES POUR L'AJOUT DANS LA DB
	foreach($attributeList["keys"] as $key)
	{
		if($i++ != 0)$add_db.=', ';
		$add_db.=$key;
	}
	foreach($attributeList["attr"] as $att)
	{
		if($i++ != 0)$add_db.=', ';
		$add_db.=$att;
	}
	$add_db.=') VALUES (';
	$i = 0;
	foreach($attributeList["keys"] as $key)
	{
		if($i++ != 0)$add_db.=', ';
		$add_db.=':'.$key;
	}
	foreach($attributeList["attr"] as $att)
	{
		if($i++ != 0)$add_db.=', ';
		$add_db.=':'.$att;
	}
	$add_db.=')";
		$requete = $connexion->prepare($req);
		$tab=array(';
	$i = 0;
	foreach($attributeList["keys"] as $key)
	{
		if($i++ != 0)$add_db.=', ';
		$add_db.='"'.$key.'"=>$this->'.$key;
	}
	foreach($attributeList["attr"] as $att)
	{
		if($i++ != 0)$add_db.=', ';
		$add_db.='"'.$att.'"=>$this->'.$att;
	}
	$add_db.=');';
	$add_db.='
		if($requete->execute($tab)){
			$requete->CloseCursor();
			$this->'.$attributeList["keys"][0].'=$connexion->lastInsertId();
			return $this->'.$attributeList["keys"][0].';
		}
		else
			return false;
	}
	';
	return $add_db;	
}


// LOAD DB
function makeLoadDb($attributeList, $tableName){
	$load_db='
	// METHODE LOAD DB
	public function load_db(){
		';
	$load_db.='global $connexion;
';
	$load_db.='		$req = "SELECT * FROM '.$tableName.' WHERE ';
	$i = 0;
	foreach($attributeList["keys"] as $key)
	{
		if($i++ != 0)$load_db.=' AND ';
		$load_db.=$key.'=:'.$key;
	}
	$load_db.='";
		$requete = $connexion->prepare($req);
		$requete->execute(array(';
		// test
	$i=0;
	foreach($attributeList["keys"] as $key)
	{
		if($i++ != 0)$load_db.=', ';
		$load_db.='"'.$key.'"=>$this->'.$key.'';
	}	
	$load_db.='));
		$requete->setFetchMode(PDO::FETCH_ASSOC);
		$tab = $requete->fetch();
		if (empty($tab)) return false;
';
	$i=0;
	foreach($attributeList["keys"] as $att){
		$load_db.='		$this->'.$att.'=$tab["'.$att.'"];
';
	}
	foreach($attributeList["attr"] as $att){
		$load_db.='		$this->'.$att.'=$tab["'.$att.'"];
';
	}
	$load_db.='		return true;
	}
	';
	return $load_db;	
}


// CONSTRUCTOR
function makeConstructor($attributeList)
{
	$construct='
	// CONSTRUCTEUR
	public function __construct($tab=array()){
		if(!empty($tab)){
			foreach($tab as $key => $val)$tab["$key"]=secure($val);
';
	foreach($attributeList["keys"] as $att)
		$construct.='			if(isset($tab["'.$att.'"])){$this->'.$att.'=$tab["'.$att.'"];}
';
	foreach($attributeList["attr"] as $att)
		$construct.='			if(isset($tab["'.$att.'"])){$this->'.$att.'=$tab["'.$att.'"];}
';
	$construct.='		}
	}
';
	return $construct;
}

// EDIT_OBJECT
function makeEditObject($attributeList)
{
	$construct='
	// EDIT_OBJECT
	public function edit_object($tab=array()){
		if(!empty($tab)){
			foreach($tab as $key => $val)$tab["$key"]=secure($val);
';
	foreach($attributeList["keys"] as $att)
		$construct.='			if(isset($tab["'.$att.'"]) && $tab["'.$att.'"] != ""){$this->'.$att.'=$tab["'.$att.'"];}
';
	foreach($attributeList["attr"] as $att)
		$construct.='			if(isset($tab["'.$att.'"]) && $tab["'.$att.'"] != ""){$this->'.$att.'=$tab["'.$att.'"];}
';
	$construct.='		}
	}
';
	return $construct;
}


// LISTE DES ATTRIBUTS
function makeAttList($attributeList)
{
	$a = "	// ATTRIBUTS
	";
	foreach($attributeList["keys"] as $att)
			$a.="protected $".$att."; // PRIMARY KEY;
	";
	foreach($attributeList["attr"] as $att)
			$a.="protected $".$att.";
	";
	return $a;
}

function getAtt($name)
{
	$attributes = array();
	foreach(getAttributes($connexion, $name) as $att)
		$attributes[] = $att;	
	return $attributes;
}
?>