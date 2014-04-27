<?php

// $req est la variable cherchée
// $evidences est un tableau contenant les variables connues
function elim($req,$evidences){

	$bdd = new PDO('mysql:host=localhost;dbname=rpc','root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	$variables=array();
	$sommes=array();
	unset($variables);
	unset($sommes);
	$reponse = $bdd->query('SELECT *  FROM Variable');
	echo "Liste des Variables : <ul>";
	while($donnees = $reponse->fetch()){
		echo '<li>'.$donnees['slug'].' : '.$donnees['nom'].'</li>';
		$variables[]=$donnees['slug'];
		
	}
	echo '</ul>';

	// $variables contient la liste des variables du réseau
	echo 'la requête est P('.$req.'|';
	affiche_evidences($evidences);
	echo ').<br>';
	echo "Liste des variables cachées <br><ul>";
	foreach ($variables as $key => $value) {
		if (($value!=$req)&&(non_evidence($value,$evidences))) {
			echo '<li>'.$value."</li>";
			$sommes[]=$value;
		}
	}
	echo '<ul>';
	// À ce stade, $sommes contient les variables "à sommer"






}
function affiche_evidences($tab){
	$i=1;
	$l=sizeof($tab);
	foreach ($tab as $key => $value) {
		echo $value;
		if($i<$l){
			echo ',';
		}
		$i=$i+1;
	}
}


function non_evidence($value,$evidences){
	$res=true;
	foreach ($evidences as $key => $val) {
		if($val==$value){
			$res=false;
		}
		# code...
	}
	return $res;
}

elim('AL',array("DR", "IN"));


?>