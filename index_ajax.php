<?php

require_once 'inc/init.php';

/***Afficher la liste des voitures***/

$liste_voiture='';
$nb_page=3;
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
//$resultat = $pdo->query('SELECT * FROM voiture');
//debug($resultat);
/*if($resultat->rowCount()>0){
	

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
}*/
require_once 'inc/header.php';
?>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<header></header>
<div class="container">
    <h1 class="alert bg-dark text-white mt-5">La liste des voitures</h1>
    <input type="hidden" id="page" name="page" value="0">
    <div id="resultat" class="row">      				
    </div>
    <div class="loader"></div>
    <div class="row mt-5">
    <button type="button" id= "button" class="ml-1 btn btn-dark">Plus de voitures </button>
    </div>

 </div>
 <script>
    $(function(){  

        let page = 1;        
        
           function reponse(responsePHP){
                if(responsePHP){
                    console.log(responsePHP.page);
                    page =responsePHP.page;
                    //$('#page').val(responsePHP.page);
                   // suite=$("#resultat").val();
                    
                    if (page == responsePHP.pages) 
                    {
                        $("#button").fadeOut();
                        
                    }
                    $("#resultat").append(responsePHP.voitures);

                }
            }
            function erreur(){                
                    $("#resultat").html("erreur est servenue");                
            }
            function loaderOn(){
                $('.loader').show();
            }
            function loaderOff(){
                $('.loader').fadeOut(2000);
            }
           function ajax(){ $.ajax({
                url: 'voiture.php',
                type: 'GET', //GET ou POST
                data : {'page':page}, // variable qui contient les données à envoyer au serveur
                dataType: 'json',
                beforeSend : loaderOn,// callback qui se déclenche avant l'envoi de la requete
                success: reponse,// callback qui se déclenche en cas de succés
                error: erreur, // callback qui se déclenche en cas d'échec de la requête
                complete : loaderOff  // callback qui se déclenche en cas d'échec de la requête
                 //callback qui se déclenche après la requête qu'elle soit en succés ou en echèc

            });
        }
        ajax();
        $(document).on('click', '#button', function(){
             
              //page = parseInt($('#page').val()) + 1;  
              page=page+1;  
              
             ajax();
        });
       });
    </script>
<?php
require_once 'inc/footer.php';



