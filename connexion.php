<?php
require_once 'inc/init.php';
$message=''; //pour afficher le message de déconnexion

//2- déconnexion du membre
//debug($_GET);
if(isset($_GET['action']) && $_GET['action']=='deconnexion'){ // si "action" est dans l'URL et qu'il a pour valeur "deconnexion", c'est que le membre a cliqué sur "Déconnexion". 
    unset($_SESSION['membre']); // on vide la session de sa partie "membre" tout en coservant l'éventuelle partie "panier".
    $message .= '<div class="alert alert-info">vous êtes déconnecté.</div>';

}



//3- On vérifie que le membre n'est pas déja connecté. Sinon on le rediriqge vers le profil
if(estConnecte()){
    header('location:profil.php');//on n'autorise pas la reconnexion mais on redirige vers profil.php 
    exit; // on quitte ce script
}


//1-Traitement du formulaire
//debug($_POST);
if(!empty($_POST)){
 //controles des formulaire
 if(empty($_POST['pseudo']) || empty($_POST['mdp']) ){ // si le pseudo ou le mot de passe est vide dans ce cas le message  d'erreur

    $contenu .='<div class="alert alert-danger">Les identifiants sont obligatoires.</div>';
 }
 if(empty($contenu)){ // si la variable est vide, c'est qu'il n'y a pas de message d'erreur

    $resultat = executeRequete("SELECT * FROM membre WHERE pseudo= :pseudo", array(':pseudo'=>$_POST['pseudo']));
    if($resultat->rowCount()== 1){ // s'il y a 1 ligne de résultat, c'est que le pseudo est en BDD: on peut alors vérifier le mdp
       
        $membre= $resultat->fetch(PDO::FETCH_ASSOC); //on "fetch" l'objet $resultat pour en extraire les données, sans boucle car le pseudo est unique en BDD.
       // debug($membre);

       if(password_verify($_POST['mdp'], $membre['mdp'])){// password_verify retourne true si le hash de la BDD correspond au mdp du formulaire
        //On peut connecter le membre : 
        
        $_SESSION['membre']=$membre; //pour connecter le membre on crée une session appelé "membre" avec toutes les infos qui viennent de la BDD
        //debug($_SESSION['membre']['statut']);
        header('location:admin/index.php');// les identifiants étant coreects, on redirige l'internaute vers la page profil.php
        exit;//et on quitte ce script

       }else{ // sinon c'est que le mdp est erroné.
        $contenu .='<div class="alert alert-danger">Erreur sur les identifiants.</div>';
       }

    }else{
        $contenu .='<div class="alert alert-danger">Erreur sur les identifiants.</div>';
    }

 }

}//fin du if(!empty($_POST)) 








//---------Affichage-----------
require_once 'inc/header.php';
?>
<div class="container">
    <h1 class="mt-4">Connexion</h1>
    <?php
    echo $message; // pour afficher le message de déconnexion
    echo $contenu;
    ?>
    <form action="" method="post">
    <div ><label for="pseudo">Pseudo</label></div>
    <div><input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?? ''; ?>"></div>

    <div><label for="mdp">Mot de passe</label></div>
    <div><input type="password" name="mdp" id="mdp" value=""></div>


    <div><input type="submit" value="Se connecter" class="btn btn-info mt-4"></div>
    </form>
</div>
<?php
require_once 'inc/footer.php';
