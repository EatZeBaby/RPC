<?php

	$variables=getVariables();
	$probabilites = getProba();
	$table_des_probas_completes = constructTab();
	$table_prete=testRequete();

	
	
	echo '<br>';
	foreach ($_POST as $key => $value) {
		echo $key.'   :        '.$value.'<br>';
	}
	


	
?>


<div class="container" style="background-color:light-grey">
	<div class="row-fluid">
		
		  
	<?php
	
	//var_dump($probabilites);
	//var_dump($_POST);

	//si toutes les variables sont bien passées en paramètres
	if(	isset($_POST['AL']) and 
		isset($_POST['DR']) and 
		isset($_POST['IN']) and 
		isset($_POST['AC']) and 
		isset($_POST['MR']) and 
		isset($_POST['PL']) and 
		isset($_POST['recherche'])
		)
		{	//et que toutes les variables ne sont pas inconnues
			if(	!($_POST['AL'] == "inconnu"
					and $_POST['DR'] == "inconnu"
					and $_POST['IN'] == "inconnu"
					and $_POST['AC'] == "inconnu"
					and $_POST['MR'] == "inconnu"
					and $_POST['PL'] == "inconnu"
					)
			)
			{
				echo '<div class="panel panel-success">
		  				<div class="panel-heading">Variables bien transmises.';
			}
		}
		else
		{
			echo '<div class="panel panel-danger">
		  				<div class="panel-heading">Erreur dans les variables.';
		}

	?>

		  </div>
		  <div class="panel-body">
		  <div class="col-lg-6">
		  <span> Sachant que: <ul> 
		    <?php 
		    	foreach ($_POST as $key => $value) {

		    		if($key!="recherche"){
		    			echo '<li>'.nomVar($key).' est <strong><span style="color:';
		    			if($value=="vrai"){echo 'green';}elseif($value=="faux"){echo "red";}else{echo "black";}
		    			echo '">'.$value.'</span></strong></li>';
		    		}
		    		
		    	}
		    ?>
		    </ul>
		    </span>


			</div>
			<div class="col-lg-6">
			 	<h4>Nous cherchons à connaitre la probabilité de : <strong style='color:teal'><ul><li><?php echo nomVar($_POST['recherche'])?></li></ul></strong></h4>
			</div>
			<div class="col-lg-6">
				<h3> Résultat : </h3>
				<?php
					afficher_requete($_POST);
					$requete=getRequete($_POST);
					$evidences=getEvidences($_POST);
					algorithme_elimination_variables($requete,$evidences);
					
				?>
				</div>
		  </div>
		</div>
</div>
	</div>





	<?php 

		function algorithme_elimination_variables($requete,$evidences){
			global $probabilites;
			
			$resultat=-1;
			
			if(array_key_exists($requete,$evidences)){
				if($evidences[$requete]=="vrai"){
					$resultat = 1;
					echo $resultat;
					echo ", car la requete est connue vraie dans les évidences.";
					
				}
				if($evidences[$requete]=="faux"){
					$resultat = 0;
					
					echo $resultat;
					echo ", car la requete est connue fausse dans les évidences.";
					
				}
				
			}
			
			else{

				foreach ($evidences as $slug => $valeur) {
					
				}
				echo $resultat;
			}
		}


		function getRequete($tab){
			return $tab["recherche"];
		}


		function getEvidences($tab){
			$res=array();
			foreach ($tab as $key => $value) {
				if(($value=="vrai")||($value=="faux")){
					$res[$key]=$value;
				}
					
			}
			

			return $res;
		}
		function nomVar($var){
			
			$bdd = new PDO('mysql:host=localhost;dbname=rpc','root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
			
			$req = $bdd->prepare('SELECT nom  FROM Variable WHERE slug=?');
			$req->execute(array($var));
			$res=$req->fetch();
			return $res[0];
				
	}
	function getVariables(){
		$bdd = new PDO('mysql:host=localhost;dbname=rpc','root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
		$variables=array();
		
		$reponse = $bdd->query('SELECT ID,slug  FROM Variable');
		//echo "Liste des Variables : <ul>";
		while($donnees = $reponse->fetch()){
			
			$tab_des_var[$donnees['ID']]=$donnees['slug'];
			//echo '<li>'.$donnees['slug'].' : '.$donnees['nom'].'</li>';
		}
		return $tab_des_var;
	}
	function hasParents($var){
		if (($var=='AL')||($var=='DR')||($var=='MR')||($var=='PL')){
			return false;
		}elseif(($var=='IN')||($var=='AC')){
			return true;
		}
	}

		function getTable($var){
		$table=array();
		$bdd = new PDO('mysql:host=localhost;dbname=rpc','root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
		
		if (! hasParents($var)){
			
			$req = $bdd->query('SELECT proba FROM '.$var);
		
			while($donnees = $req->fetch()){
				
				$table[$var]=$donnees['proba'];
				$table['-'.$var]=1-$table[$var];//
			
			}
			
		}else{

			if($var=='AC'){
				$req = $bdd->query('SELECT proba,PL,MR,`IN` FROM AC');
				
				while($donnees = $req->fetch()){
					$pl="PL";
					$mr="MR";
					$in="IN";
					if($donnees['PL']==0){$pl="-AL";}
					if($donnees['MR']==0){$mr="-MR";}
					if($donnees['`IN`']==0){$in="-IN";}
					
					$v=$var.' '.$pl.' '.$mr.' '.$in;

					$table[$v]=$donnees['proba'];
					$table['-'.$v]=1-$table[$v];//
				
				}



			}elseif($var=='IN'){
				$req = $bdd->query('SELECT proba,AL,DR FROM `IN`');
				
				while($donnees = $req->fetch()){
					$al="AL";
					$dr="DR";
					if($donnees['AL']==0){$al="-AL";}
					if($donnees['DR']==0){$dr="-DR";}
					
					$v=$var.' '.$al.' '.$dr;

					$table[$v]=$donnees['proba'];
					$table['-'.$v]=1-$table[$v];//
				
				}

			}

		}
		//var_dump($table);
		//echo'<br>';
		return $table;
		

	}
	function constructTab(){
		$var=getVariables();
		$liste=array();

		foreach ($var as $id => $slug) {
			$liste[$slug]=getTable($slug);
			//echo $id.':'.$slug."<br>";
			//$liste[$slug]=1;
		}
		//var_dump($liste);
		var_dump($liste);
	}
	function afficher_requete($tab){
		$evidences=array();
		foreach ($tab as $key => $value) {
			if(($value=="vrai")||($value=="faux")){
				$evidences[$key]=$value;
			}
			
		}
		$l=sizeof($evidences);
		$var=$tab["recherche"];
		echo 'P('.$var.'|';
			$i=1;
			foreach ($evidences as $key => $value) {
				
				if($value=="vrai"){echo $key;}
					elseif($value=="faux"){echo "¬".$key;}
					if($i<$l){echo',';}
					$i++;

			}
			echo ')=';
	}
	function getNumFromSlug($t){
		
		if($t=='AL'){return '1';}
		if($t=='DR'){return '2';}
		if($t=='IN'){return '3';}
		if($t=='AC'){return '4';}
		if($t=='MR'){return '5';}
		if($t=='PL'){return '6';}
	}
	

	function getProba(){
			$bdd = new PDO('mysql:host=localhost;dbname=rpc','root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
			$probabilites=array();
			unset($probabilites);
			$reponse = $bdd->query('SELECT *  FROM Probabilites');
			//echo "Liste des probabilites : <ul>";
			while($donnees = $reponse->fetch()){
				//echo '<li>'.$donnees['slug'].' : '.$donnees['nom'].'</li>';
				$probabilites[$donnees['nom']]=$donnees['valeur'];
			}
			return $probabilites;//*/

	}


	function getProbaOld(){

			$bdd = new PDO('mysql:host=localhost;dbname=rpc','root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
			$variables=array();
			unset($variables);
			$reponse = $bdd->query('SELECT *  FROM Variable');
			//echo "Liste des Variables : <ul>";
			while($donnees = $reponse->fetch()){
				//echo '<li>'.$donnees['slug'].' : '.$donnees['nom'].'</li>';
				$variables[$donnees['slug']]=$donnees['nom'];
			}
			
			foreach ($variables as $slug => $value) {
				
				
				$req = $bdd->prepare('SELECT X.slug  FROM Variable X
										WHERE (SELECT Y.parent FROM Parente Y 
												WHERE Y.fils=? AND X.ID=Y.parent)');
				$v=getNumFromSlug($slug);
				
				$req->execute(array($v));
				$temp=$slug;
				$i=0;
				while($parents = $req->fetch()){
					if($i==0){
						$temp=$temp. ' |';
					}
					$temp=$temp.' '.$parents[0];

					$i=$i+1;
				}
				echo $temp .'<br>';//*/
				
			}


	}
	function testRequete(){
		$tab_des_evid=getEvidences($_POST);
		$temp;
		$tab_des_var=getVariables();

		foreach ($tab_des_var as $id => $var) {
			foreach ($tab_des_evid as $evi => $valeur) {
				
				//$temp[$var]=

			}
		}
	}

	

		
	?>