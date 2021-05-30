<?php

session_start();
require 'database.php';


if(!isset($_SESSION['user_id']) ){
    header("Location: /projet/index.php");
} else {

    $records = $conn->query('SELECT * FROM users where id = ' .$_SESSION['user_id']);
	
	$records->execute();
    
    while($donnees = $records->fetch()){
        if($donnees['expert'] != 1 && $donnees['administrateur'] != 1){
            if(!isset($_SESSION['user_id']) ){
                header("Location: /projet/index.php");
            } else {
                header("Location: /projet/accueil.php");

            }   
        }
    }

}
?>

<!DOCTYPE html>
    <html>
        <head>
            <title> Propositions de spectacles </title>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="assets/css/style.css">
            <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        </head>

        <body>

            <div class="header">
                <a href="/projet/accueil.php">Spectacles Advisor</a>
                
            </div>


            <div class="container">
                <br /> <h1> Propositions de spectacles </h1>
                
                <a href="javascript:history.go(-1)"><button type="button" class="btn btn-secondary"> Retour </button></a>

                <br/>

                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Lieu</th>
                        <th scope="col">Lien</th>
                        <th scope="col">Ajouté par</th>
                        <th scope="col">  </th>
                        </tr>
                    </thead>
                    <br/>
                    <tbody>

                    <?php
                        
                        require 'database.php';
                        
                        

                        if(isset($_SESSION['user_id'])){
                            
                            $records = $conn->query('SELECT * FROM spectacle where statut=0');
                            
                            while($donnees = $records->fetch()){
                                print('<form method="post" action="spectaclesProposition.php">');
                                    print('<tr>');

                                        print('<th>'); print($donnees['id'] ."\n"); print('</th>');
                                        print('<td>'); print($donnees['titre'] ."\n");  print('</td>');
                                        print('<td>'); print($donnees['auteur'] ."\n"); print('</td>');
                                        print('<td>'); print($donnees['lieu'] ."\n"); print('</td>');
                                        print('<td>'); print($donnees['lien'] ."\n"); print('</td>');
                                        
                                        $users = $conn->query('SELECT pseudonym FROM users where id=' .$donnees['id_users']);
                                        $row = $users->fetch();

                                        print('<td>'); print($row['pseudonym'] ."\n"); print('</td>');
                                            print('<td>');

                                                print('<button type="submit" class="btn btn-primary">');
                                                    print('Accepter la proposition');
                                                print('</button>');

                                        print('</td>');

                                    print('</tr>');
                                    print('<input id="prodId" name="id" type="hidden" value="'.$donnees['id'].'">');
                                print('</form>');

                                
                            
                                
                            }
                        }
                            
                        ?>

                        <?php
                            if (isset($_POST['id'])) {
                            
                                $id = $_POST['id']; 
                                var_dump($id);
                                
                                $sql = "UPDATE spectacle SET statut=1 WHERE id=?";
                                $stmt= $conn->prepare($sql);
                                $stmt->execute([$id]);
                                header("Location: /projet/accueil.php");
                            }
                        ?>
                        </tbody>
                </table>
            </div>


        </body>

    </html>