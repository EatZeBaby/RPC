

<div class="container">
	<div class="row">
	<h1> Projet RPC - Miage Dauphine</h1>
	<hr>

	</div>
	<div class="row">
	<div class="col-lg-3">
		<?php
	$var_alcool 	= new Var_Bays("alcool");
	$var_drogue 	= new Var_Bays("drogue");
	$var_infarctus 	= new Var_Bays("infarctus");
	$var_infarctus->addParent("alcool");
	$var_infarctus->addParent("drogue");
	
	$var_alcool->afficheParents();
	$var_drogue->afficheParents();
	$var_infarctus->afficheParents();


	$var_infarctus->probaCond(
								0.108,//$iad,  
								0.072,//$i_ad,
								0.012,//$ia_d,
								0.008,//$i_a_d,
								0.016,//$_iad,
								0.144,//$_i_ad,
								0.064,//$_ia_d,
								0.576//$_i_a_d
								);//*/

	//$var_infarctus->setProba(0.5);
	//echo $var_infarctus->getProbaVrai();

	echo 'coucou '. $var_infarctus->getProbaCond("iad");
	
	
	
	?>


	</div>

		<div class="col-lg-6 ">
			<table class="table">
				<thead>
					<tr>
						 <td>Variable</td>
						 <td>Vrai</td>
						 <td>Faux</td>
						 <td>Inconnu</td>
					</tr>
				</thead>
				<tbody>
						<form method="post">
						<tr><td>Alcool</td>
							<td><input <?php if(isset($_POST["alcool"])&&$_POST["alcool"]=="vrai")   echo " checked " ?> name="alcool" value="vrai" type="radio"  required="required" ></td>
							<td><input <?php if(isset($_POST["alcool"])&&$_POST["alcool"]=="faux")   echo " checked " ?> name="alcool" value="faux" type="radio" required="required" ></td>
							<td><input <?php if(isset($_POST["alcool"])&&$_POST["alcool"]=="inconnu")echo " checked " ?> name="alcool" value="inconnu" type="radio" required="required" ></td>
						</tr>
						<tr><td>Drogue</td>
							<td><input <?php if(isset($_POST["drogue"])&&$_POST["drogue"]=="vrai")   echo " checked " ?>name="drogue" value="vrai" type="radio" required="required" ></td>
							<td><input <?php if(isset($_POST["drogue"])&&$_POST["drogue"]=="faux")   echo " checked " ?>name="drogue" value="faux" type="radio"></td>
							<td><input <?php if(isset($_POST["drogue"])&&$_POST["drogue"]=="inconnu")echo " checked " ?>name="drogue" value="inconnu" type="radio"></td>
						</tr>
						<tr><td>Infarctus</td>
							<td><input <?php if(isset($_POST["infarctus"])&&$_POST["infarctus"]=="vrai")    echo " checked " ?>name="infarctus" value="vrai" required="required"  type="radio"></td>
							<td><input <?php if(isset($_POST["infarctus"])&&$_POST["infarctus"]=="faux")    echo " checked " ?>name="infarctus" value="faux" type="radio"></td>
							<td><input <?php if(isset($_POST["infarctus"])&&$_POST["infarctus"]=="inconnu") echo " checked " ?>name="infarctus" value="inconnu" type="radio"></td>
						</tr>
						<tr><td>Mauvaise Condition de Route</td>
							<td><input <?php if(isset($_POST["mauvaiseroute"])&&$_POST["mauvaiseroute"]=="vrai")    echo " checked " ?>name="mauvaiseroute" value="vrai" required="required"  type="radio"></td>
							<td><input <?php if(isset($_POST["mauvaiseroute"])&&$_POST["mauvaiseroute"]=="faux")    echo " checked " ?>name="mauvaiseroute" value="faux" type="radio"></td>
							<td><input <?php if(isset($_POST["mauvaiseroute"])&&$_POST["mauvaiseroute"]=="inconnu") echo " checked " ?>name="mauvaiseroute" value="inconnu" type="radio"></td>
						</tr>
						<tr><td>Pluie</td>
							<td><input <?php if(isset($_POST["pluie"])&&$_POST["pluie"]=="vrai")    echo " checked " ?>name="pluie" value="vrai" required="required"  type="radio"></td>
							<td><input <?php if(isset($_POST["pluie"])&&$_POST["pluie"]=="faux")    echo " checked " ?>name="pluie" value="faux" type="radio"></td>
							<td><input <?php if(isset($_POST["pluie"])&&$_POST["pluie"]=="inconnu") echo " checked " ?>name="pluie" value="inconnu" type="radio"></td>
						</tr>
						<tr><td>Accident</td>
							<td><input <?php if(isset($_POST["accident"])&&$_POST["accident"]=="vrai")    echo " checked " ?>name="accident" value="vrai" required="required"  type="radio"></td>
							<td><input <?php if(isset($_POST["accident"])&&$_POST["accident"]=="faux")    echo " checked " ?>name="accident" value="faux" type="radio"></td>
							<td><input <?php if(isset($_POST["accident"])&&$_POST["accident"]=="inconnu") echo " checked " ?>name="accident" value="inconnu" type="radio"></td>
						</tr>
						
				</tbody>

			</table>
			<button type="submit"> Valider </button></br>
						
			<?php 

				foreach($_POST as $variable=> $valeur){
					if (($valeur=="vrai")||($valeur=="faux")||($valeur=="inconnu")){
						$var_en_cours[$variable]=$valeur;
					}
				}

				foreach($_POST as $variable=> $valeur){
					
					if (($valeur=="vrai")||($valeur=="faux")){
						echo "Sachant que " . $variable . " est " . $valeur. "</br>";
					}
				}
				
				foreach($_POST as $variable=> $valeur){
					if ($valeur=="inconnu"){
						echo "On peut essayer de trouver ". $variable . " qui est inconnu. </br>";
					}
				}
				foreach($_POST as $variable=> $valeur){
					if ($valeur=="inconnu"){
						echo '<button name="recherche" type="submit" value="'.$variable.'">'. $variable . "</button> </br>";
					}
				}

				if(isset($_POST["recherche"])){
					echo "Vous avez choisi de chercher ".$_POST["recherche"];
					echo ' : p('.$_POST["recherche"];
						$i=0;
					foreach($_POST as $variable=> $valeur){
						
						if ($valeur=="vrai"){
							if($i==0){echo'|';}
							echo  $variable .',';
							
						}
						$i=$i+1;

					}
					echo ")=";
					if($_POST["recherche"]=="infarctus"){
						echo $var_infarctus->getProbaCond(parse($_POST["recherche"],$var_en_cours));
					}
					if($_POST["recherche"]=="alcool"){
						if($_POST["infarctus"]=="inconnu"){
							echo $var_alcool->getProbaVrai();
						}
						if($_POST["infarctus"]=="vrai"){
							echo $var_alcool->getProbaVrai();
						}
						if($_POST["infarctus"]=="faux"){
							echo $var_alcool->getProbaVrai();
						}
						
					}
					if($_POST["recherche"]=="drogue"){
						echo $var_drogue->getProbaCond(parse($_POST["recherche"],$var_en_cours));
					}
					
				}

			?>
			</form>
		</div>
	</div>
</div>
<?php
	function parse($recherche,$var_en_cours){
		$res="".$recherche[0];
		foreach ($var_en_cours as $cle => $valeur) {
			if($valeur=="vrai"){
				$res=$res.$cle[0];
			}
			if($valeur=="faux"){
				$res=$res.'_'.$cle[0];
			}	
		}
		//echo 'res:'$res;
		return $res;
	}

?>



