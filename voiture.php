<?php
require_once 'inc/init.php';
$contenu =array("page"=>"",

                "voitures"=>"");
// On détermine sur quelle page on se trouve
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}
$contenu['page']=$currentPage;
// On détermine le nombre total d'articles
$sql = 'SELECT COUNT(*) AS nb_voiture FROM voiture';

// On prépare la requête
$query = $pdo->prepare($sql);

// On exécute
$query->execute();

// On récupère le nombre d'articles
$result = $query->fetch();

$nbLignes = (int) $result['nb_voiture'];

// On détermine le nombre d'articles par page
$parPage = 3;

// On calcule le nombre de pages total
$pages = ceil($nbLignes / $parPage);
$contenu['pages']=$pages;
// Calcul du 1er article de la page
$premier = ($currentPage * $parPage) - $parPage;

$sql = 'SELECT * FROM voiture ORDER BY marque ASC LIMIT :premier, :parpage';

// On prépare la requête
$query = $pdo->prepare($sql);

$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

// On exécute
$query->execute();

// On récupère les valeurs dans un tableau associatif
$voitures = $query->fetchAll(PDO::FETCH_ASSOC);


foreach($voitures as $voiture){
    //debug($voiture);//puisque $voiture est un tableau, on le parcourt avec une foreach :
        $contenu['voitures'] .=' <div class="col-md-4 mt-3">
        <div class="card">
            <img class="img-fluid card-img-top img" src="'.$voiture['photo'].'" alt="'.$voiture['marque'].'">
            <div class="card-body">
                <h5 class="card-title">'. $voiture['marque'] . '</h5>
                <p class="card-text">'. $voiture['kilometrage'] .' </p>
                <p class="card-text">'. $voiture['tarif'] .' </p>
                <p><a href="?file=../'.$voiture['fiche'].'">Télécharger</a></p>
                <a href="?id_voiture='.$voiture['id_voiture'].'" class="btn btn-dark" onclick="return confirm(\'Etes-vous certain de vouloir supprimer cette voiture ?\');">Supprimer</a>
                
                <a href="update_voiture.php?id_voiture='.$voiture['id_voiture'].'" class="btn btn-dark">Modifier</a>
                
        </div>
        </div></div>';
        //on ajoute les liens "modifier" et "supprimer" :
        


} 
echo json_encode($contenu);


