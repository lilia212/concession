<?php

require_once 'inc/init.php';

//-----------------Traitement PHP ----------
//Traitement des données du formulaire :
//debug($_POST);
//tableau englobe la la liste des types de contact

$nom_fichier='';

$mail_destinataire="lilia.maalem@gmail.com";

if(!empty($_POST)){ // si le formulaire a été envoyé et $_POST n'est pas vide
    // On contrôle tous les champs du formulaire :
        
		         
		
		 if(!isset($_POST['nom']) || strlen($_POST['nom']) < 2) {
		   //si le champ "marque" n'existe pas ou que sa longeur est inférieur à 2 ou superieur à 20 (selon la BDD), alors on met un message à l'internaute       
		   $contenu .= '<div class="alert alert-danger">La nom doit contenir minimum 2  caractères.</div>';
		 }
		 if(!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 ){
            //si le champ "marque" n'existe pas ou que sa longeur est inférieur à 2 ou superieur à 20 (selon la BDD), alors on met un message à l'internaute       
            $contenu .= '<div class="alert alert-danger">La prénom doit contenir minimum 2 caractères.</div>';
          }
		  if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			//si le champ "tarif" n'existe pas ou n'est pas un entier ou que sa longeur est  superieur à 5 (selon la BDD), alors on met un message à l'internaute       
			$contenu .= '<div class="alert alert-danger">l\'email n\'est pas valide</div>';
        }
        if(!isset($_POST['sujet']) || strlen($_POST['sujet']) < 4) {
            //si le champ "marque" n'existe pas ou que sa longeur est inférieur à 2 ou superieur à 20 (selon la BDD), alors on met un message à l'internaute       
            $contenu .= '<div class="alert alert-danger">Le champ sujet est obligatoire.</div>';
          }
        if(!isset($_POST['message']) || strlen($_POST['message']) < 10) {
            //si le champ "marque" n'existe pas ou que sa longeur est inférieur à 2 ou superieur à 20 (selon la BDD), alors on met un message à l'internaute       
            $contenu .= '<div class="alert alert-danger">Le champ message est obligatoire !!.</div>';
        }
		 
		  
	
		 
    
    //----------------
    
    if(empty($contenu)){// 
       
      
      $mail = $_POST['email'];
      $sujet = $_POST['sujet'];

      $text = str_replace("\n.", "\n..", $_POST['message']);
      $message = "Nom : ". $_POST['nom']. " Prénom : " . $_POST['prenom']."\n";
      $message .= "Message : ".$text;
      $headers =array(
        'From' => $mail,
        'Reply-To' => $mail
        

      );
      $success=mail($mail_destinataire,$sujet,$message,$headers);
      if ($success){
        $contenu .='<div class="alert alert-success">Votre mail est envoyé</a></div>';

      } else{
        $contenu .='<div class="alert alert-danger">Echec de l\'envoi !</div>';

      }

       
      }// fin de if (empty($contenu))  

} 




//------------ AFFICHAGE-------

require_once 'inc/header.php';
?>
<header></header>
<div class="container">
    <h1 class="alert bg-dark text-white mt-5">Contact</h1>

    <?php echo $contenu; // pour afficher les messages ?>
    <form action="" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-3">
            <label for="nom">Nom</label>
        </div>
		  <div class="col-md-9">
            <input class="form-control" type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? ''; ?>" placeholder="nom">
        </div>            
        
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            <label for="prenom">Prénom</label>
        </div>
		  <div class="col-md-9">
            <input class="form-control" type="text" name="prenom" id="nom" value="<?php echo $_POST['prenom'] ?? ''; ?>" placeholder="Prénom">
        </div>            
        
    </div>
	<div class="row mt-3">
        <div class="col-md-3">
            <label for="email">Email</label>
        </div>
		  <div class="col-md-9">
            <input class="form-control" type="text" name="email" id="email" value="<?php echo $_POST['email'] ?? ''; ?>" placeholder="Email">
        </div>    
    
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            <label for="sujet">Sujet</label>
        </div>
		  <div class="col-md-9">
            <input class="form-control" type="text" name="sujet" id="sujet" value="<?php echo $_POST['sujet'] ?? ''; ?>" placeholder="Sujet">
        </div>    
    
    </div>

	<div class="row  mt-3">
        <div class="col-md-3">
            <label for="message">Message</label>
        </div>
		  <div class="col-md-9">
          <textarea class="form-control" name="message" id="message" cols="30" rows="10"><?php echo $_POST['message'] ?? ''; ?></textarea>
            
        </div>     
        
    </div> 		
   
    
	
   
    <div class="form-group"><input type="submit" value="Envoyer" class="btn-block btn btn-dark mt-4"></div>
</form>
</div>    
 <?php

require_once 'inc/footer.php';

