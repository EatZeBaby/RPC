

<div class="container">
	
	<div class="row">
	<div class="col-lg-2">
		<?php
	
	
	$bdd = new PDO('mysql:host=localhost;dbname=rpc','root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	$variables=array();
	unset($variables);
	
	$reponse = $bdd->query('SELECT *  FROM Variable');
	//echo "Liste des Variables : <ul>";
	while($donnees = $reponse->fetch()){
		//echo '<li>'.$donnees['slug'].' : '.$donnees['nom'].'</li>';
		$variables[$donnees['slug']]=$donnees['nom'];
		
	}
	//echo '</ul>';
	
	
	?>


	</div>

		<div class="well col-lg-8 ">
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
						<form action="?p=resultat" method="post">
						<?php 
							foreach ($variables as $key => $value) {
								echo '<tr><td>'.$value.'</td>';
								echo '<td><input';
								if(isset($_POST[$key])&&$_POST[$key]=="vrai") echo " checked " ;
								echo ' name="'.$key.'" value="vrai" type="radio" required="required" ></td><td><input';
								
								if(isset($_POST[$key])&&$_POST[$key]=="faux") echo " checked " ;
								echo ' name="'.$key.'" value="faux" type="radio" required="required" ></td><td><input';
								
								if(isset($_POST[$key])&&$_POST[$key]=="inconnu")  echo " checked ";
								echo ' name="'.$key.'" value="inconnu" type="radio" required="required" ></td></tr>';
							}
						?>
						
				</tbody>

			</table>
			<div class="row">
				

					<?php echo '<hr>'; 
						foreach ($variables as $key => $value) {
							echo '<button name="recherche" value="'.$key.'" type="submit"class="btn btn-info" style="display:inline-bloc;margin:4px">'.$value.'</button>';
						}
					?>
				
			</div>

			
</div></div><hr>			
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
				$res=$res.'-'.$cle[0];
			}	
		}
		//echo 'res:'$res;
		return $res;
	}

?>



