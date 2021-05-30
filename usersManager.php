<?php

session_start();
require 'database.php';


if(!isset($_SESSION['user_id']) ){
    header("Location: /projet/index.php");
} else {

    $records = $conn->query('SELECT * FROM users where id = ' .$_SESSION['user_id']);
	
	$records->execute();
    
    while($donnees = $records->fetch()){
        if($donnees['administrateur'] != 1){
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
            <title> Gérer les utilisateurs </title>
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
                <br /> <h1> Gestion des utilisateurs </h1>
                
                <a href="javascript:history.go(-1)"><button type="button" class="btn btn-secondary"> Retour </button></a>

                <br/>

                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">Pseudonym</th>
                        <th scope="col">Editer les informations</th>
                        </tr>
                    </thead>
                    <br/>
                    <tbody>

                    <?php
                        
                        require 'database.php';
                        
  
                        if(isset($_SESSION['user_id'])){
                            
                            $records = $conn->query('SELECT * FROM users where id <> ' .$_SESSION['user_id']);
                            
           
                            while($donnees = $records->fetch()){

                                $admin = $donnees['administrateur'];
                                $contrib = $donnees['contributeur'];
                                $expert = $donnees['expert'];

                                print('<tr>');

                                print('<th>'); print($donnees['id'] ."\n"); print('</th>');
                                print('<td>'); print($donnees['email'] ."\n");  print('</td>');
                                print('<td>'); print($donnees['pseudonym'] ."\n"); print('</td>');
                                    print('<td>');

                                        print('<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal' .$donnees['id'].'">');
                                            print('Modifier les droits');
                                        print('</button>');

                                    print('</td>');

                                print('</tr>');


                                print('<div class="modal fade" id="exampleModal'.$donnees['id'].'"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">');
                                print('<div class="modal-dialog">');
                                    print('<div class="modal-content">');
                                        print('<div class="modal-header">');
                                            print('<h5 class="modal-title" id="exampleModalLabel">'); echo($donnees['pseudonym']); print('</h5>');
                                            print('<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">'); print('</button>');
                                        print('</div>');
                                        print('<div class="modal-body">');
                                            print('<form action="usersManager.php" method="POST">');
                                                print('<div class="mb-3">');

                                                    print('<label for="inputPassword5" class="form-label">'); print('Identifiant utilisateur'); print('</label>');
                                                    print('<input readonly type="text" name="id" class="form-control" id="exampleInputEmail1" value="' . $donnees['id'] . '" >');
                                                    
                                                    print('<label for="inputPassword5" class="form-label">'); print('Administrateur'); print('</label>');
                                                    print('<input type="text" name="admin" class="form-control" id="exampleInputEmail1" value="' . $admin . '" >');
                                                   
                                                    print('<br>');
                                                    
                                                    print('<label for="inputPassword6" class="form-label">'); print('Contributeur'); print('</label>');
                                                    print('<input type="text" name="contrib" class="form-control" id="exampleInputEmail1" value="' . $contrib . '" >');
                                                    
                                                    print('<br>');  

                                                    print('<label for="inputPassword7" class="form-label">'); print('Expert'); print('</label>');
                                                    print('<input type="text" name="expert" class="form-control" id="exampleInputEmail1" value="' . $expert . '" >');

                                                print('</div>');
                                            
                                            print('</div>');
                                        print('<div class="modal-footer">');

                                        
                                            print('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">'); print('Fermer'); print('</button>');
                                            print('<button type="submit" name="submit" class="btn btn-primary">'); print('Changer les informations'); print('</button>');
                                        print('</div>');
                                        print('</form>');
                                    print('</div>');
                                print('</div>');
                                print('</div>');
                            
                                
                            }

                            $records->closeCursor(); 
                        
                        }

                        if (isset($_POST['submit'])) {
                         
                            $id = $_POST['id']; 
                            $admin = $_POST['admin']; 
                            $contrib = $_POST['contrib'];
                            $expert = $_POST['expert'];
                            
                            $message = '';

                            if(($admin == 0 || $admin ==1) && ($contrib == 0 || $contrib ==1) && ($expert ==0 || $expert ==1)){
                                $sql = "UPDATE users SET administrateur=?, expert=?, contributeur=? WHERE id=?";
                                $stmt= $conn->prepare($sql);
                                $stmt->execute([$admin,  $expert, $contrib, $id]);

                                $message = 'Mise à jour avec succès';
                                
                            } else {
                                $message = 'Erreur de Mise à jour';
                            }
                            echo '<meta http-equiv="refresh" content="0">';

                        }

                        

                    ?>
                        </tbody>
                </table>
            </div>


        </body>

    </html>