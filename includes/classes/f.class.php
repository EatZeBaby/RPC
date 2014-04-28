<?php
class f
{
	private $_nom;
	private $_parentsASommer;


	public function __construct($nom,$liste_parents) 
	  {
	    
	    $this->setNom($nom); 
	    foreach ($liste_parents as $cle => $parent) {
	    	$this->_parentsASommer[$parent]=true;
	    }
	    
	  }

	
}
?>