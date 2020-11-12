<?php

require_once 'inc/init.php';

/***Afficher la liste des voitures***/

$liste_voiture='';
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
		}
		
}


$resultat = $pdo->query('SELECT * FROM voiture');
//debug($resultat);
if($resultat->rowCount()>0){
	

	while($voiture = $resultat->fetch(PDO::FETCH_ASSOC) ){
		
   ///on peut faire avec une foreach

        $liste_voiture .=' <div class="col-md-4 mt-3">
        <div class="card">
            <img class="img-fluid card-img-top img" src="'.$voiture['photo'].'" alt="'.$voiture['marque'].'">
            <div class="card-body">
                <h5 class="card-title">'. $voiture['marque'] . '</h5>
                <p class="card-text">'. $voiture['kilometrage'] .' </p>
                <p class="card-text">'. $voiture['tarif'] .' </p>
                <a href="detail_voiture.php?id_voiture='.$voiture['id_voiture'].'" class="btn btn-dark">Détails</a>
                <a href="?file='.$voiture['fiche'].'" class="btn btn-dark">Télécharger</a>
            </div>
        </div></div>';

		

		
	}
					
}else{
	$contenu='<div class="alert alert-warning">La liste des voitures est vide !!!</div>';
}

require_once 'inc/header.php';


?>
<header></header>
<div class="container">
    <h1 class="alert bg-dark text-white mt-5">La liste des voitures</h1>
    <div class="row">
       
		
				
					
			
				<?php 
				echo $liste_voiture;  
				echo $contenu;

					?>
				
				
			
    </div>
           
       
 
            
        
</div>

<?php
require_once 'inc/footer.php';



