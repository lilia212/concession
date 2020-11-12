<?php
require_once 'inc/init.php';

//-----------------Traitement PHP ----------
//Traitement des données du formulaire :
//debug($_POST);

if(!empty($_POST)){ // si le formulaire a été envoyé
// On contrôle tous les champs du formulaire :
// || double pipestr
    if(!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20){
       //si le champ "pseudo" n'existe pas ou que sa longeur est inférieur à 4 ou superieur à 20 (selonla BDD), alors on met un message à l'internaute       
        $contenu .= '<div class="alert alert-danger">Le pseudo doit contenir entre 4 et 20 caractères.</div>';
    }

    if(!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 20){
        $contenu .= '<div class="alert alert-danger">Le mot de passe doit contenir entre 4 et 20 caractères.</div>';
    }

    if(!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20){
        $contenu .= '<div class="alert alert-danger">Le nom doit contenir entre 2 et 20 caractères.</div>';
    }

    if(!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20){
        $contenu .= '<div class="alert alert-danger">Le nom doit contenir entre 4 et 20 caractères.</div>';
    }

    if(!isset($_POST['email']) ||  !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        //fonction prédéfinie filter_var() avec le paramètre FILTER_VALIDATE_EMAIL retourne true ['email'] est bien format email.
        $contenu .= '<div class="alert alert-danger">L\'émail n\'est pas valide.</div>';
    }
    if(!isset($_POST['civilite']) || ($_POST['civilite']!= 'm' && $_POST['civilite']!= 'f')){
      //les chaines string en php sont sensible à la case, par contre sql ne le sont pas sauf si on met attribut binary
      //si le champ "civilite" n'existe pas OU  que sa valeur est différent de "m" et de "f" en même temps.
      //Attention à la paire de () autour du &&.
      $contenu .= '<div class="alert alert-danger">La civilité n\'est pas valide.</div>';

    }
    if(!isset($_POST['ville']) || strlen($_POST['ville']) < 1 || strlen($_POST['ville']) > 20){
        $contenu .= '<div class="alert alert-danger">Le champ ville doit contenir entre 1 et 20 caractères.</div>';
    }
        if(!isset($_POST['code_postal'] ) || !preg_match('#^[0-9]{5}$#', $_POST['code_postal']) ){
            $contenu .= '<div class="alert alert-danger">Le code postal n\'est pas valide.</div>';
    }
    if(!isset($_POST['adresse']) || strlen($_POST['adresse']) < 4 || strlen($_POST['ville']) > 50){
        $contenu .= '<div class="alert alert-danger">L\'adresse doit contenir entre 4 et 50 caractères.</div>';
    }
    //----------------
    //S'il n'y a pas d'erreur sur le formulaire, on vérifie que le pseudo est disponible puis on insère le membre en BDD: 
    if(empty($contenu)){// si est vide notre variable, c'est qu'il n'y a pas de message d'erreur
    // on vérifie que le pseudo est disponbile :
        $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo'=>$_POST['pseudo']));
      //debug($resultat);  

      if($resultat->rowCount() > 0){
        $contenu .='<div class="alert alert-danger">Le pseudo existe déjà. Veuillez en choisir un autre.</div>';
      }else{
        // Le pseudo est disponbile, On insère le membre en BDD:
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        //debug($mdp); cette fonction retourne la clé de hashage de notre mot de passe selon l'algorithme "bcrypt" par défaut. il faudra sur la page de connexion comparer le hash de la BDD avec celui de mdp fourni lors de la connexion avec la fonction password_verify().

        $succes= executeRequete("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) VALUES(:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, :statut)",
        array(
            ':pseudo'   => $_POST['pseudo'] ,
            ':mdp'      => $mdp ,
            ':nom'      => $_POST['nom'] ,
            ':prenom'   => $_POST['prenom'] ,
            ':email'    => $_POST['email'] ,
            ':civilite' => $_POST['civilite'] ,
            ':ville'    => $_POST['ville'] ,
            ':code_postal' => $_POST['code_postal'] ,
            ':adresse'  => $_POST['adresse'] ,
            ':statut'  => 0 


        ));

        if($succes){
            $contenu .='<div class="alert alert-success">Vous êtes inscrit. pour vous connecter <a href="connexion.php">Cliquez ici</a></div>';
        }else{
            $contenu .='<div class="alert alert-danger">Une erreur est survenue ...</div>' ;
        }
      }

    } // fin de if (empty($contenu))   

} // fin de if (!empty($_POST))


//------------ AFFICHAGE-------



require_once 'inc/header.php';
?>
<div class="container">
    <h1 class="mt-4">Inscription</h1>

    <?php echo $contenu; // pour afficher les messages ?>
    <form action="" method="post">
    <div ><label for="pseudo">Pseudo</label></div>
    <div><input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?? ''; ?>"></div>

    <div><label for="mdp">Mot de passe</label></div>
    <div><input type="password" name="mdp" id="mdp" value="<?php echo $_POST['mdp'] ?? ''; ?>"></div>

    <div><label for="nom">Nom</label></div>
    <div><input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? ''; ?>"></div>

    <div><label for="prenom">Prénom</label></div>
    <div><input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>"></div>

    <div><label for="email">Email</label></div>
    <div><input type="text" name="email" id="email" value="<?php echo $_POST['email'] ?? ''; ?>"></div>

    <div><label for="civilite">Civilité</label></div>
    <div><input type="radio" name="civilite" id="civilite" value="m" checked>Homme</div>
    <div><input type="radio" name="civilite" id="civilite" value="f"  <?php if(isset($_POST['civilite']) && $_POST['civilite'] =='f' ) echo 'checked' ;?>>Femme</div>

    <div><label for="ville">Ville</label></div>
    <div><input type="text" name="ville" id="ville" value="<?php echo $_POST['ville'] ?? ''; ?>"></div>

    <div><label for="code_postal">Code Postal</label></div>
    <div><input type="text" name="code_postal" id="code_postal" value="<?php echo $_POST['code_postal'] ?? ''; ?>"></div>

    <div><label for="adresse">Adresse</label></div>
    <div><textarea name="adresse" id="adresse" cols="30" rows="10"><?php echo $_POST['adresse'] ?? ''; ?></textarea></div>
    <div><input type="submit" value="S'inscrire" class="btn btn-info mt-4"></div>
    </form>
</div>
<?php

require_once 'inc/footer.php';
