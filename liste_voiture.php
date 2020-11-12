
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
if($resultat->rowCount()==0){
	
	$contenu='<div class="alert alert-warning">La liste des voitures est vide !!!</div>';
	
					
}
/******** AFFICHAGE  ************/
require_once 'inc/header.php';


?>
<div class="container">
    <h1 class="bg-dark text-white mt-5">La liste des voitures</h1>
    <div class="row">
        <div class="col-md-12">
		<form action="" method="post">
				<table class="table table-striped border">
				<tr>
					<th>ID</th>
					<th>Marque</th>
					<th>Kilométrage</th>
					<th>Tarif</th>
					<th>Photo</th>
					<th>Fiche</th>
					<th>Voir</th>
				</tr>
					
			
				
				
				
		
				<?php 
				while ($voiture = $resultat->fetch(PDO::FETCH_ASSOC)) {
					// debug($); // tableau associatif
		
					echo '<tr>';
						foreach ($voiture as $indice => $information) {
							
							if ($indice == 'photo') {
								echo '<td><img src="'. $information .'" style="width:80px"></td>';
							}elseif($indice == 'fiche'){
								echo '<td><a class="btn bg-dark btn-block" href="?file='.$information.'" alt="voiture">Télécharger</a></td>';
							}
							
							else {
								echo '<td>' . $information . '</td>';
							}
						}
		
						echo '<td><a class="btn btn-info btn-block" href="detail_voiture.php?id_voiture=' . $voiture['id_voiture'] . '">détail</a></td>';
		
					echo '</tr>';
				}
				echo $contenu;
				?>
				

				
				
				</table>
		<form>
    </div>
           
       
 
            
        
</div>

<?php
require_once 'inc/footer.php';



