<?php
/*
   1- Vous affichez le détail complet du contact demandé dans liste_contact.php, y compris la photo. Si le contact n'existe pas, vous laissez un message. 

*/

require_once 'inc/init.php';
$message='';

if(!empty($_GET['file'])){
		
			$file=$_GET['file'];
		if (file_exists($file)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($file).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				readfile($file);
				exit;
		}else{
         $contenu .='<div class="alert alert-warning">Le fichier n\'existe pas !!!</div>';
      }
		
}

   /***Afficher les détails***/
   if(isset($_GET['id_voiture'])){ 
      $param=array(':id_voiture'=>$_GET['id_voiture']);

      //Echappement des données :
      //évite les risques XSS(js) et CSS en neutralisant les chevrons en particulier en entités HTML.
      $param=echappement($param);
      $resultat = $pdo->prepare('SELECT * FROM voiture WHERE id_voiture = :id_voiture');
      $succes= $resultat->execute($param);       //debug($resultat);              
      $voiture = $resultat->fetch(PDO::FETCH_ASSOC);
      
   }
         //isset()  vérifie si la variable existe (et non null) alors que empty vérifie si le variable contient 0,
         // "", NULL, false ou alors si elle n'est pas définie. Dans le cas présente dans $_GET, alors la variable $ contact n'est pas déclarée, elle est donc empty
         
         
  

//Affichage
require_once 'inc/header.php';


?>
<header></header>
<div class="container">
    <h1 class="alert bg-dark text-white mt-5">Détails voiture</h1>
    <div class="row">
        <div class="col-md-12">
            
         <?php
         
         if(!empty($voiture)){?>         
           <h1><?php echo $voiture['marque'];?>  </h1>
            
            <ul>              
              
              <li>Kilométrage : <?php echo $voiture['kilometrage'];?> </li>
              <li>Tarif : <?php echo $voiture['tarif'];?> </li>              
               
            </ul> 
            <img src="<?php echo $voiture['photo'];?>" style="width:100%" alt="voiture">  
            <p><a href="index.php" class="text-black">Retour à la liste des voitures</a></p>
            <p><a class="btn btn-dark btn-block" href="?id_voiture=<?php echo $voiture['id_voiture'];?> &file=<?php echo $voiture['fiche'];?>" alt="voiture">Télécharger</a></p>
               
                  
               
         <?php
         }else{
            $contenu='<div class="alert alert-warning">La voiture n\'existe pas !!!</div>';
         }
                 
         ?>			
   </div>      
 
       
        
    <?php echo $contenu; ?>
    </div>
</div>
<?php
require_once 'inc/footer.php';




