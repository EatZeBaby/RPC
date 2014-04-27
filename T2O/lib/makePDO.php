<?php
function makePDO(){
	$string = '$host = "'.$_SESSION["host"].'";
$port = '.$_SESSION["port"].';
$user = "'.$_SESSION["db_user"].'";
$bd = "'.$_SESSION["db_name"].'";
$password = "";

try{
$connexion = new PDO(\'mysql:host=\'.$host.\';
	port=\'.$port.\';
	dbname=\'.$bd,
	$user,
	$password,
	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(PDOException $e){
	echo $e;
}';
return $string;
}