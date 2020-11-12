<?php
/*3- Effectuer les vérifications nécessaires :
	Les champs nom et prénom contiennent 2 caractères minimum, le téléphone 10 chiffres
	Le type de voiture doit être conforme à la liste des types de voitures
	L'email doit être valide
    En cas d'erreur de saisie, afficher des messages d'erreurs au-dessus du formulaire*/
require_once '../inc/init.php';
if(!estAdmin()){
    header('location:../connexion.php');
    exit;

}

//-----------------Traitement PHP ----------
//Traitement des données du formulaire :
//debug($_POST);
//tableau englobe la la liste des types de voiture



   
   // appel d'une fonction qui fait tout les verfications des champs voitures
   // elle retourne un tableau associatif avec deux paramètre (1:contenu, 2:photo_bdd)
   
    if(!empty($_POST)){ // si le formulaire a été envoyé et $_POST n'est pas vide
        // On contrôle tous les champs du formulaire :
            
            $photo_bdd = '';
            $fiche_bdd  ='';
            if(isset($_POST['photo_actuelle'])){ // si existe "photo_actuelle" dans $_POST, c'est que je suis en train de modifier le produit : je veux remettre le chemin de la photo en BDD
                $photo_bdd=  $_POST['photo_actuelle']; // alors on affecte le chemin de la photo actuelle à la variable $photo_bdd qui est insérée en BDD.
    
            }
            if(isset($_POST['fiche_actuelle'])){ // si existe "photo_actuelle" dans $_POST, c'est que je suis en train de modifier le produit : je veux remettre le chemin de la photo en BDD
                $fiche_bdd=  $_POST['fiche_actuelle']; // alors on affecte le chemin de la photo actuelle à la variable $photo_bdd qui est insérée en BDD.
    
            } 
               
            
             if(!isset($_POST['marque']) || strlen($_POST['marque']) < 2 || strlen($_POST['marque']) > 20){
               //si le champ "marque" n'existe pas ou que sa longeur est inférieur à 2 ou superieur à 20 (selon la BDD), alors on met un message à l'internaute       
               $contenu .= '<div class="alert alert-danger">La marque doit contenir entre 2 et 20 caractères.</div>';
             }
             if(!isset($_POST['kilometrage']) || !is_numeric($_POST['kilometrage'])  || strlen($_POST['kilometrage']) > 6){
                //si le champ "kilometrage" n'existe pas ou n'est pas un entier ou que sa longeur est  superieur à 6 (selon la BDD), alors on met un message à l'internaute       
                $contenu .= '<div class="alert alert-danger">Le kilométrage doit être numerique et ne depasse pas 6 chiffre.</div>';
              }
              if(!isset($_POST['tarif']) || !is_numeric($_POST['tarif'])  || strlen($_POST['tarif']) > 5){
                //si le champ "tarif" n'existe pas ou n'est pas un entier ou que sa longeur est  superieur à 5 (selon la BDD), alors on met un message à l'internaute       
                $contenu .= '<div class="alert alert-danger">Le tarif doit être  numerique et ne depasse pas 5 chiffre.</div>';
                }
                
              if(!empty($_FILES['photo']['name'])){
                $date = new DateTime();
                $extention="";
    
                $val= $date->getTimestamp();
                $nom_fichier = $_FILES['photo']['name'];
                $pos = strpos($nom_fichier, '.');
                $extention= substr($nom_fichier,$pos);
                $nom_fichier = 'photo_' . $val . $extention; 			
                $photo_bdd ='photo/'.$nom_fichier;
                copy($_FILES['photo']['tmp_name'],"../".$photo_bdd);   
                //	  
             }
              if(!empty($_FILES['fiche']['name'])){
                
                $date = new DateTime();
                $extention="";
    
                $val= $date->getTimestamp();
                $nom_fichier = $_FILES['fiche']['name'];
                $pos = strpos($nom_fichier, '.');
                $extention= substr($nom_fichier,$pos);
                $nom_fichier = 'fiche_' . $val . $extention; 			
                $fiche_bdd ='photo/'.$nom_fichier;
                copy($_FILES['fiche']['tmp_name'],"../".$fiche_bdd);             
                
                
                 
                //
          
             }
           
    
    if(empty($contenu)){// 
       
      //debug($resultat);          

        $requete="UPDATE voiture SET marque=:marque, kilometrage=:kilometrage, tarif=:tarif,  photo=:photo, fiche=:fiche WHERE id_voiture=:id_voiture";
		  
		  $param= array(
                ':id_voiture'  =>$_GET['id_voiture'] ,
				':marque'        => $_POST['marque'] ,
				':kilometrage'     => $_POST['kilometrage'] ,
                ':tarif'  => $_POST['tarif'] ,            
                ':photo'      => $photo_bdd ,            
                ':fiche'       => $fiche_bdd 
				);

		  $param = echappement($param);	
		  $resultat = $pdo->prepare($requete);		  
		  $succes = $resultat->execute($param);

        if($succes){
            $contenu .='<div class="alert alert-success">Le voiture est modifié. </div>';
        }else{
            
            $contenu .='<div class="alert alert-danger">Une erreur est survenue ...</div>' ;
        }
      }// fin de if (empty($contenu))  
      
    }
if(isset($_GET['id_voiture']) ){
    
    $param=echappement( array(':id_voiture'=> $_GET['id_voiture'] ));
    $resultat = $pdo->prepare("SELECT * FROM voiture WHERE id_voiture=:id_voiture");
    $resultat->execute($param);

    if($resultat->rowCount() == 1){ // s'il y a 1 ligne de résultat, c'est que le pseudo est en BDD: on peut alors vérifier le mdp            
         $voitures = $resultat->fetch(PDO::FETCH_ASSOC);  
     }
}else{
    $contenu .= '<div class="alert alert-danger">Cette voiture n\'existe pas dans la liste.</div>';
    
}



//------------ AFFICHAGE-------

require_once '../inc/header.php';
?>
<div class="container">
    <h1 class="alert bg-dark text-white mt-5">Modifier la voiture</h1>

    <?php echo $contenu; // pour afficher les messages ?>
    <form action="" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-12">
            <input class="form-control" type="text" name="marque" id="marque" value="<?php echo $_POST['marque'] ??  $voitures['marque'] ?? ''; ?>" placeholder="Marque">
        </div>
		              
        
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <input class="form-control" type="text" name="kilometrage" id="kilometrage" value="<?php echo  $_POST['kilometrage'] ??  $voitures['kilometrage'] ?? '' ; ?>" placeholder="kilometrage">
        </div>  
        <div class="col-md-6">
            <input class="form-control" type="text" name="tarif" id="tarif" value="<?php echo $_POST['tarif'] ??  $voitures['tarif'] ?? ''; ?>" placeholder="Tarif">
        </div>	
			
    </div>
    <div class="row mt-3">
	 
		<div class="col-md-12">
        <input type="file" name="photo" id="photo">
            
           <?php if(isset( $voitures['photo'])){
            echo '<div>Photo actuelle du produit</div>';
            echo '<div><img src="../'. $voitures['photo'] .'" style="width: 200px"></div>';
            // on affiche la photo actuelle dans le chemin est dans le champ "photo" de la bdd donc dans $produit.
            echo '<input type="hidden" name="photo_actuelle" value="'. $voitures['photo'].'">';
            //on crée ce champ caché pour remettre le chemin de la photo actuelle dans le formulaire, donc dans $_POST à l'indice "photo_actuelle". Ainsi on ré-insère ce chemin en BDD lors de la modification.
            }   ?>         
			
            
		</div>
        <div class="col-md-12">
        <input type="file" name="fiche" id="fiche">
            
           <?php if(isset($voitures['fiche'])){
            echo '<div>Fiche actuelle du produit</div>';
            echo '<div>'. $voitures['fiche'] .'</div>';
            // on affiche la photo actuelle dans le chemin est dans le champ "photo" de la bdd donc dans $produit.
            echo '<input type="hidden" name="fiche_actuelle" value="'. $voitures['fiche'].'">';
            //on crée ce champ caché pour remettre le chemin de la photo actuelle dans le formulaire, donc dans $_POST à l'indice "photo_actuelle". Ainsi on ré-insère ce chemin en BDD lors de la modification.
            }   ?>         
			
            
		</div>
    </div>   
    
    <div class="form-group"><input type="submit" value="Enregister" class="btn-block btn btn-dark mt-4"></div>
    </form>
</div>    
 <?php

require_once '../inc/footer.php';

