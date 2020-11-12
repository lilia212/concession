<?php
require_once '../inc/init.php'; // on remonte vers le dossier parent avec ../

//1 on vérifie que le membre est bien admin, sinon  on le redirige vers la page de connexion :
if(!estAdmin()){
    header('location:../connexion.php');
    exit;

} 

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
if(isset($_GET['id_voiture'])){
    $resultat= executeRequete ("DELETE FROM voiture WHERE id_voiture= :id_voiture", array(':id_voiture'=>$_GET['id_voiture']));
    //on obtient 1 lors de la supression d'un voiture

    if($resultat->rowCount()==1){ //si le DELETE retourne 1 ligne c'est que la requête a marché
        $contenu .='<div class="col-lg-12 alert alert-success"> Le voiture a bien été supprimé.</div>';
    }else{
        $contenu .='<div class="col-lg-12 alert alert-danger"> Le voiture n\'a pu être supprimé.</div>';
    }
}  
// On détermine sur quelle page on se trouve
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}
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
$parPage = 6;

// On calcule le nombre de pages total
$pages = ceil($nbLignes / $parPage);

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





require_once '../inc/header.php'; 
// --6Liste des voitures dans une table 
//$resultat  = executeRequete("SELECT * FROM voiture");
//$contenu .="<br>Le nombre de voitures est ".$resultat->rowCount();



    //les lignes de voiture
    //debug($resultat);
   // while($voiture=$resultat->fetch(PDO::FETCH_ASSOC)){
    foreach($voitures as $voiture){
        //debug($voiture);//puisque $voiture est un tableau, on le parcourt avec une foreach :
            $contenu .=' <div class="col-md-4 mt-3">
            <div class="card">
                <img class="img-fluid card-img-top img" src="../'.$voiture['photo'].'" alt="'.$voiture['marque'].'">
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


//2- onglets de navigation
?>

<div class="container">
    <h1 class="mt-4">Gestion des voitures</h1>
    <div class="row">


    <?php
    echo $contenu; // pour afficher les messages et le tableau des voitures
    ?>
    </div>
    <div class="row mt-4 ml-1">
    <nav>
                    <ul class="pagination">
                        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="?page=<?= $currentPage - 1 ?>" class="page-link ">Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                          <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                          <li class="page-item  <?= ($currentPage == $page) ? "active" : "" ?> ">
                                <a href="?page=<?= $page ?>" class="page-link "><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                          <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                          <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </nav>
    </div>
    </div>
<?php
require_once '../inc/footer.php'; 
