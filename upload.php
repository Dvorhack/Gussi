<?php
if(isset($_FILES['avatar']))
{ 
     $dossier = '/home/pi/site/sounds/';
     $fichier = basename($_FILES['avatar']['name']);
     echo $fichier;
    if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}
header("Location: http://192.168.4.1")
?>