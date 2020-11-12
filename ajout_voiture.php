<?php

require_once 'inc/init.php';

//-----------------Traitement PHP ----------
//Traitement des données du formulaire :
//debug($_POST);
//tableau englobe la la liste des types de contact

$nom_fichier='';



if(!empty($_POST)){ // si le formulaire a été envoyé et $_POST n'est pas vide
    // On contrôle tous les champs du formulaire :
        
		$photo_bdd = '';
		$file_bdd  ='';           
		
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
			copy($_FILES['photo']['tmp_name'],$photo_bdd);   
			//	  
		 }
		  if(!empty($_FILES['file']['name'])){
			
			$date = new DateTime();
			$extention="";

			$val= $date->getTimestamp();
			$nom_fichier = $_FILES['file']['name'];
			$pos = strpos($nom_fichier, '.');
			$extention= substr($nom_fichier,$pos);
			$nom_fichier = 'fiche_' . $val . $extention; 			
			$photo_bdd ='photo/'.$nom_fichier;
			copy($_FILES['photo']['tmp_name'],$photo_bdd);  
			
			
			
			$file_bdd ='photo/'.$nom_fichier;
			copy($_FILES['photo']['tmp_name'],$file_bdd);   
			//
	  
		 }
		 
	
		 
    
    //----------------
    
    if(empty($contenu)){// 
       
      //debug($resultat);          

        $requete="INSERT INTO voiture(marque, kilometrage, tarif, photo, fiche) VALUES(:marque, :kilometrage, :tarif, :photo, :fiche)";
		  
		  $param= array(
			':marque'          => $_POST['marque'] ,
			':kilometrage'     => $_POST['kilometrage'] ,
			':tarif'           => $_POST['tarif'] ,
			':photo'           => $photo_bdd ,            
            ':fiche'           => $file_bdd            
            );

		  $param = echappement($param);	
		  $resultat = $pdo->prepare($requete);		  
		  $succes = $resultat->execute($param);

        if($succes){
            $contenu .='<div class="alert alert-success">La voiture est enregistré. </div>';
        }else{
            $contenu .='<div class="alert alert-danger">Une erreur est survenue ...</div>' ;
        }
      }// fin de if (empty($contenu))  

} 




//------------ AFFICHAGE-------

require_once 'inc/header.php';
?>
<header></header>
<div class="container">
    <h1 class="alert bg-dark text-white mt-5">Nouvelle Voiture</h1>

    <?php echo $contenu; // pour afficher les messages ?>
    <form action="" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-3">
            <label for="marque">Marque</label>
        </div>
		  <div class="col-md-9">
            <input class="form-control" type="text" name="marque" id="marque" value="<?php echo $_POST['marque'] ?? ''; ?>" placeholder="marque">
        </div>            
        
    </div>
	<div class="row mt-3">
        <div class="col-md-3">
            <label for="kilometrage	">kilometrage</label>
        </div>
		  <div class="col-md-9">
            <input class="form-control" type="text" name="kilometrage" id="kilometrage" value="<?php echo $_POST['kilometrage'] ?? ''; ?>" placeholder="kilometrage">
        </div>    
    
    </div>

	<div class="row  mt-3">
        <div class="col-md-3">
            <label for="tarif">Tarif</label>
        </div>
		  <div class="col-md-9">
            <input class="form-control" type="text" name="tarif" id="tarif" value="<?php echo $_POST['tarif'] ?? ''; ?>" placeholder="tarif">
        </div>     
        
    </div> 		
   
    <div class="row mt-3">
		<div class="col-md-3">
				<label for="photo">Choisir une Photo :</label>
		</div>
	 
		<div class="col-md-6 form-group">
			<input class="form-control" type="file" name="photo" id="photo">
		</div>
    </div>
	<div class="row mt-3">
		<div class="col-md-3">
				<label for="file">Choisir une fiche :</label>
		</div>	 
		<div class="col-md-6">
			<input class="form-control" type="file" name="file" id="file">
		</div>
    </div>
   
    <div class="form-group"><input type="submit" value="Enregister" class="btn-block btn btn-dark mt-4"></div>
</form>
</div>    
 <?php

require_once 'inc/footer.php';

