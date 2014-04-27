<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Table2Objects Project</title>
</head>

<body onload="prettyPrint()">
<h1>Welcome to the Tables2Objects Project</h1>
<?php
include('lib/function.php');
if(isset($_POST["cancel"]))
{
	$_SESSION=array();
	include('includes/etape1.php');
}
elseif(isset($_POST["etape1"]))
{
	$_SESSION["host"] = $_POST["host"];
	$_SESSION["port"] = $_POST["port"];
	$_SESSION["db_name"] = $_POST["db_name"];
	$_SESSION["db_user"] = $_POST["db_user"];
	$_SESSION["password"] = $_POST["password"];
	if(($connexion=connect_db($_SESSION["db_name"], $_SESSION["host"], $_SESSION["db_user"], $_SESSION["password"], $_SESSION["port"])) != false)
	{
		$_SESSION["tables"] = getTableNames($connexion);
		include('includes/etape2.php');
	}
}
elseif(isset($_POST["etape2"]))
{
	if(($connexion=connect_db($_SESSION["db_name"], $_SESSION["host"], $_SESSION["db_user"], $_SESSION["password"], $_SESSION["port"])) != false)
	{
		$_SESSION["tables"] = getTableNames($connexion);
		include('includes/etape3.php');
	}
}
else{
	include('includes/etape1.php');	
}
echo'<hr />';
echo 'Version 0.3 - Florent Bejina';
echo '<hr />';
echo '14/07/2013 - patch note - V 0.3<br/>
- fix de la fonction getAttributInput()<br/>
- Ajout de la fonction edit_object($attributs)<hr/>
09/07/2013 - patch note - V 0.2<br/>
- Ajout getAttrInput($params);<br/>
- Protection XSS des classes sur le constructeur & sur les setters<br/>
- load_db() retourne désormais true/false<br />
- Génération du protocole de connexion à la BDD en accord avec les classes<br />
- si "date" dans l\'attribut ->getDate("Le d/m/Y")';
echo '<hr />';
//echo '<strong>$_POST</strong> : ';var_dump($_POST);echo '<br />';
//echo '<strong>$_SESSION</strong> : ';var_dump($_SESSION);echo '<br />';

?>

</body>
</html>