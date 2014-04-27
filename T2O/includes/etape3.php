<h3>Done !</h3>
<link href="prettify/src/prettify.css" type="text/css" rel="stylesheet" />
<script src="prettify/src/prettify.js" type="text/javascript"></script>
<style type="text/css">
code{
	border: 1px solid black;
	background:#FFC;
	margin-left: 30px;
	margin-right:20px;	
}
</style>
<?php 
	include('lib/makeClass.php');
	include('lib/makePDO.php');
	//include('lib/makeConnexion.php');
	
	//echo '<pre class="code prettyprint">'.makeConnexion($_SESSION).'</pre>';
	
	echo '<p><strong style="color: red;">CONNEXION MYSQL with PDO</strong></p>';
	echo '<pre class="code prettyprint">'.makePDO().'</pre>';
	$_SESSION["idTable"]=$_POST["idTable"];
	foreach($_SESSION["idTable"] as $idTable)
	{
		echo '<p><strong>Table : '.$_SESSION["tables"][$idTable].'</strong></p>';
		echo '<pre class="code prettyprint">'.makeClass($_SESSION["tables"][$idTable]).'</pre>';
	}
	unset($_SESSION["tables"]);
?>
<form action="" method="post">
    <p>
    	<input type="submit" name="cancel" value="Cancel" />
    </p>
	
</form>