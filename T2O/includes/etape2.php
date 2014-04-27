<?php



?>
<h2>Step 2 : Select tables</h2>
<form action="" method="post">
    <p>
    	<input type="submit" name="etape2" value="Next" />
    	<input type="submit" name="cancel" value="Cancel" />
    </p>
	<?php
		$i=0;
		foreach($_SESSION["tables"] as $nomTable)
		{
			echo '<p><input type="checkbox" name="idTable[]" value="'.$i++.'"/> : <strong>'.$nomTable.'</strong></p>';		
		}
	?>
    <p>
    	<input type="submit" name="etape2" value="Next" />
    	<input type="submit" name="cancel" value="Cancel" />
    </p>
	
</form>