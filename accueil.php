<?php

session_start();

require 'database.php';
require_once( "sparqllib.php" );


if(isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id, email, pseudonym, administrateur, expert, contributeur, password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

} else {
    header("Location: /projet/index.php");
}
?>


<!DOCTYPE html>
<html>
<head>
	<title> Accueil </title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="style/accueil.css">

	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</head>
<body>

	<div class="header">
		<a href="/projet/accueil.php">Spectacles Advisor</a>
	</div>

    <div class="container">
		<br /> <h1> Bienvenue <?= $user['pseudonym']; ?> </h1>
		<h2> Une envie de spectacle ? </h2>
        <br /><br /> 
        <?php
            if ($user['administrateur'] == 1) {
                print '<a href="usersManager.php"><button type="button" class="btn btn-secondary"> Gérer les utilisateurs </button></a> | ';
            }
            
            if($user['expert'] == 1 || $user['administrateur'] == 1 ) {
                print '<a href="spectaclesProposition.php"><button type="button" class="btn btn-secondary"> Demandes de spectacles </button></a>';

            }

		?>
        <br /><br />
            <a href="logout.php"><button type="button" class="btn btn-secondary">Déconnexion </button></a>
        <hr/>

    </div>
    
    <div class="container">
        <form action="accueil.php" method="POST">
            <div class="row">
                <div class="col-md-4 col-xs-1 col-md-4">
                    <input type="text" placeholder="Titre" name="titre">
                </div>
                <div class="col-md-4 col-xs-1 col-md-1">
                    <input type="text" placeholder="Lieu" name="lieu">
                </div>
                <div class="col-md-4 col-xs-1 col-md-1">
                    <input class="form-control" id="date" name="date" placeholder="JJ/MM/AAAA" type="text"/>
                </div>
            
            </div>
            <button type="submit" class="btn btn-primary"> Rechercher </button>
            
            <?php
                require 'database.php';

                if($user['expert'] == 1 || $user['administrateur'] == 1 || $user['contributeur'] == 1 ) {
                    print('<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">');
                        print('Recommander un spectacle');
                    print('</button>');
                } 

                print('<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">');
                print('<div class="modal-dialog">');
                    print('<div class="modal-content">');
                        print('<div class="modal-header">');
                            print('<h5 class="modal-title" id="exampleModalLabel">');  print('</h5>');
                            print('<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">'); print('</button>');
                        print('</div>');
                        print('<div class="modal-body">');
                            print('<form action="accueil.php" method="POST">');
                                print('<div class="mb-3">');
                                    print('<label for="inputPassword5" class="form-label">'); print('Titre'); print('</label>');
                                    print('<input type="text" name="titre" class="form-control" id="exampleInputEmail1">');

                                    print('<label for="inputPassword6" class="form-label">'); print('Auteur'); print('</label>');
                                    print('<input type="text" name="auteur" class="form-control" id="exampleInputEmail1">');

                                    print('<label for="inputPassword7" class="form-label">'); print('Lieu'); print('</label>');
                                    print('<input type="text" name="lieu" class="form-control" id="exampleInputEmail1">');

                                    print('<label for="inputPassword8" class="form-label">'); print('URL'); print('</label>');
                                    print('<input type="text" name="lien" class="form-control" id="exampleInputEmail1">');

                                print('</div>');
                            
                            print('</div>');
                        print('<div class="modal-footer">');
                            print('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">');print('Fermer'); print('</button>');
                            print('<button type="submit" name="submit" class="btn btn-primary">'); print('Recommander'); print('</button>');
                        print('</div>');
                        print('</form>');
                    print('</div>');
                print('</div>');
                print('</div>');


                if (isset($_POST['submit'])) {

                    if(!empty($_POST['titre']) && !empty($_POST['auteur']) && !empty($_POST['lieu']) && !empty($_POST['lien']) ){

                        
                        $sql = "INSERT INTO spectacle (titre, auteur, lieu, id_users, lien) VALUES (:titre, :auteur, :lieu , :id_users, :lien)";
                        $stmt = $conn->prepare($sql);
                    
                        $stmt->bindParam(':titre', $_POST['titre']);
                        $stmt->bindParam(':auteur', $_POST['auteur']);
                        $stmt->bindParam(':lieu', $_POST['lieu'] );
                        $stmt->bindParam(':id_users', intval($_SESSION['user_id']));
                        $stmt->bindParam(':lien', $_POST['lien'] );

                        $stmt->execute();

                        
                        echo '<meta http-equiv="refresh" content="0">';
                    } else {

                        echo '<meta http-equiv="refresh" content="0">';

                    }
                }
            
            ?>

        </form>
        <br/>
        <br/>
    </div>

    <div class="container">
        <div class="container">
            
                <?php
                    require_once( "sparqllib.php" );
                    
                    $db = sparql_connect( "https://data.bnf.fr/sparql" );
                    if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
                    sparql_ns( "rdf","http://www.w3.org/1999/02/22-rdf-syntax-ns#" );
                    sparql_ns( "dbp","http://dbpedia.org/property/" );
                    sparql_ns( "dbo","http://dbpedia.org/ontology/" );
                    sparql_ns( "xsd","http://www.w3.org/2001/XMLSchema#" );

                    
                    $sparql = "PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>
                    PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                    PREFIX rdagroup1elements: <http://rdvocab.info/Elements/>
                    PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                    PREFIX dcterms: <http://purl.org/dc/terms/>
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX dcmitype: <http://purl.org/dc/dcmitype/>
                    SELECT ?Spectacle ?Titre ?Date ?focus ?Nom_Lieu ?Latitude ?Longitude
                    WHERE {
                    ?Spectacle rdf:type dcmitype:Event .
                    ?Spectacle dcterms:title ?Titre .
                    ?Spectacle dcterms:date ?Date .
                    ?Spectacle rdagroup1elements:placeOfProduction ?Lieu .
                    ?Lieu foaf:focus ?focus .
                    ?focus rdfs:label ?Nom_Lieu .
                    ?focus geo:lat ?Latitude .
                    ?focus geo:long ?Longitude .
                    } LIMIT 2";

                    $result = sparql_query( $sparql ); 
                    if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
                    
                    $fields = sparql_field_array( $result );

                    
                    print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
                    
                    $compteur = 0;
                    
            
                    while( $row = sparql_fetch_array( $result ))
                    {
                        print('<div class="card">');

                        foreach( $fields as $field )    
                        {
                            if($compteur== 0 ){
                            
                                $url = $row[$field];
                                print('<div class="card-header">');
                            }
                            
                            if($compteur==1){
                                print('<strong>' . $row[$field] . '</strong>'); 
                                
                            }

                            if($compteur==2){
                                print('</div>');
                                print('<div class="card-body">');
                                print('<p class="card-text"> Date de sortie : ' .$row[$field]); print('</p>');
                                
                            }

                            if($compteur==5){
                                $latitude = $row[$field];

                                
                            }
                            if($compteur==6){
                                $longitude = $row[$field];
                                print(' | ');
                                print('<a href="https://www.google.com/maps/dir//'.$latitude. ',' .$longitude. '" target="_blank" class="btn btn-secondary"> Afficher sur Google Maps </a>');
                                
                                print('</div>');
                                
                            }

                            if($compteur==4){
                                print('<p class="card-text"> Où : ' .$row[$field]); print('</p>');
                                print('<a href="'.$url. '" target="_blank" class="btn btn-primary"> Pour en savoir plus </a>');
                                
                                
                                
                            }
                            $compteur+=1;
                        }
                        $compteur=0;
                    
                        print('</div>');

                        print('<br/>');
                        print('<hr/>');

                    }

                ?>

                

                <?php
                    require 'database.php';

                        $records = $conn->query('SELECT * FROM spectacle where statut=1 ORDER BY RAND() LIMIT 2');
                        
                        print('<h3> Recommandation par les membres </h3>');
                        print('<br/>');

           
                        while($donnees = $records->fetch()){
                            print('<div class="card">');
                                print('<div class="card-header">');
                                    print('<strong>' .$donnees['titre']. ' / ' .$donnees['auteur']. '</strong>'); 
                                print('</div>');
                                
                                
                                print('<div class="card-body">');
                                    
                                    print('<p class="card-text"> Où : ' . $donnees['lieu'] . '</p>');

                                    $users = $conn->query('SELECT pseudonym FROM users where id=' .$donnees['id_users']);
                                    $row = $users->fetch();

                                    print('<p class="card-text"> Recommandé par : ' .$row['pseudonym']. '</p>');

                                    print('<a href="'.$donnees['lien']. '" target="_blank" class="btn btn-primary"> Pour en savoir plus </a>');
                                print('</div>');
                        
                            print('</div>');
                            print('<br/>');
                        }



                ?>
        </div>
    </div>


</body>

<!-- Extra JavaScript/CSS added manually in "Settings" tab -->
<!-- Include jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'dd/mm/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>
</html>