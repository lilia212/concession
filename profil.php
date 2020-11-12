<?php
require_once 'inc/init.php';
//- vous redirigez le membre NON connecté vers la page de connexion.
//code

require_once 'inc/header.php';

if(!estConnecte()){
    header('location:connexion.php'); // on fait une redirection vers connexion.php
    exit;   // et on quitte le script

}else{
   
    ?>
    <div class="container">
        <hr>
        <h1 class="mt-4">Profil</h1>
        <h2>Bonjour :<?php echo $_SESSION['membre']['nom'].' '. $_SESSION['membre']['prenom'] ; ?> !</h2>
        <h3>Mes coordonnées</h3>
        <ul>
            <li>Email: <?php echo $_SESSION['membre']['email']; ?></li>
            
            <li>Adresse: <?php echo $_SESSION['membre']['adresse']; ?></li>
            
            <li>Code Postal: <?php echo $_SESSION['membre']['code_postal']; ?></li>
            
            <li>Ville: <?php echo $_SESSION['membre']['ville']; ?></li>
            
        </ul>
    </div>
    
   <?php
    
}
//2-vous affichez le profil :
//dans un <h2>Bonjour prenom nom!</h2>

//vous affichez dans une liste <ul><li> :
//email
//adresse
//code postal
//ville
?>

<?php

require_once 'inc/footer.php';