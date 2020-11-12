<?php
require_once '../inc/init.php'; // on remonte vers le dossier parent avec ../
/* Exercice :
1-un seul administrateur a accès à cette page.
2-Afficher dans cette page, tous les membres inscrits dans une table HTML, avec toutes les informtions sauf le mot de passe, vous ajpouter une colonne "action" dans la quelle vous mettez un lien supprimez un membre vous meme qui êtes connectés.
*/
    
//1 on vérifie que le membre est bien admin, sinon  on le redirige vers la page de connexion :
if(!estAdmin()){
    header('location:../connexion.php');
    exit;

}
//3- suppression du membre

if(isset($_GET['id_membre'])){
    //si on a id_membre dans l'URL, c'est qu'on demande sa suppression
    if($_GET['id_membre'] != $_SESSION['membre']['id_membre']){// si l'id passé dans L'url est différent de l'ID dans la session, donc du membre connecté, c'est donc que je n'ai pas cliqué sur moi même
        //..............
    $resultat= executeRequete ("DELETE FROM membre WHERE id_membre= :id_membre", array(':id_membre'=>$_GET['id_membre']));
    //on obtient 1 lors de la supression d'un membre

    if($resultat->rowCount()==1){ //si le DELETE retourne 1 ligne c'est que la requête a marché
        $contenu .='<div class="alert alert-success"> Le membre a bien été supprimé.</div>';
    }else{
        $contenu .='<div class="alert alert-danger"> Le membre n\'a pu être supprimé .</div>';
    }
   }else{

    $contenu .='<div class="alert alert-danger">Vous ne pouvez pas supprimer votre propre profil !</div>';
} 
} 


require_once '../inc/header.php'; 

$resultat  = executeRequete("SELECT id_membre,	pseudo, nom, prenom,	email,	civilite,	ville,	code_postal,	adresse,	statut FROM membre");
$contenu .="Le nombre des membres est ".$resultat->rowCount();
$contenu .='<table class="table">';
  // Les entêtes
    $contenu .='<tr>';
    $contenu .='<th>ID</th>';
    $contenu .='<th>Pseudo</th>';
    $contenu .='<th>Nom</th>';
    $contenu .='<th>Prénom</th>';
    $contenu .='<th>Email</th>';
    $contenu .='<th>Civilite</th>';
    $contenu .='<th>Ville</th>';
    $contenu .='<th>Code postal</th>';
    $contenu .='<th>Adresse</th>';
    $contenu .='<th>Statut</th>';
    $contenu .='<th>Action</th>'; //colonne pour les liens modifier et supprimer 

    $contenu .='</tr>';
    while($membre=$resultat->fetch(PDO::FETCH_ASSOC)){
        //debug($produit);//puisque $produit est un tableau, on le parcourt avec une foreach :
            $contenu .='<tr>';
            
           
            foreach($membre as $indice => $information){             

                    if($indice =='statut'){
                         $information =='1' ? $information ='Admin' : $information='User';
                    }             
                                
                    $contenu .='<td>'.$information .'</td>';
                 
            }
            
            $contenu .='<td>
            
            <a href="?id_membre='.$membre['id_membre'] .'"  onclick="return confirm(\'Etes-vous certain de vouloir supprimer ce membre ?\');">Supprimer</a>
      </td>';
        }
       

        $contenu .='</tr>';

    
     
    $contenu .='</table>';
echo '<div class="container">';
echo '<h1 class="mt-4">Gestions des membres</h1>';    
echo $contenu; // pour afficher les messages et le tableau des produits
echo '</div>';
require_once '../inc/footer.php'; 