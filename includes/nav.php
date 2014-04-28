<div class="container  ">
  <h1 style="text-align:center"> Projet RPC - Miage Dauphine</h1>
 
<hr>


<nav class="col-lg-4 col-lg-offset-4 navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        
      </button>
      <a class="navbar-brand" href="/">RPC</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div style="background-color:none" class="navbar-collapse nav-justified" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(isset($_GET["p"])&&($_GET["p"]=='sujet'))   {echo'class="active"';}  ?>><a href="?p=sujet">Sujet</a></li>
        <li <?php if(isset($_GET["p"])&&($_GET["p"]=='accueil')) {echo'class="active"';}?>><a href="?p=accueil">Projet</a></li>
        <li <?php if(isset($_GET["p"])&&($_GET["p"]=='reseau')) {echo'class="active"';}?>><a href="?p=reseau">Reseau</a></li>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>