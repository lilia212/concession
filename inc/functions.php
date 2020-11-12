<?php
//Ce fichier contient toutes les fonctions et sera inclus dans toutes les pages.
function debug($variable) {  
    echo '<div style="border:1px solid orange">';
        echo '<pre>';
         print_r($variable);
        echo '<pre>';
    echo '</div>';
}
function estConnecte(){
    //cette fonction indique si l'internaute est connecté.
    if(isset($_SESSION['membre'])){// si existe "memebre" dans la session, c'est que l'internaute est passé par la page de connexion avec les identifiants, et que nous avons rempli cette session avec ses informations.
        return true;// il  est connecté
    }else{
        return false; // il n'est pas connecté
        }    
}

//cette function indique si le membre est admin et connecté.
function estAdmin(){
    if(estConnecte() && $_SESSION['membre']['statut'] == 1){
        return true;
    }else{
        return false;
    }
}
//Fonction qui fait les échappements des champs avant l'enregistrement à la base de données
// pour eviter les injection XSS (js) ET CSS HTML
//Fonction qui exécute des requêtes
function executeRequete($requete, $param= array()){ // le paramètre $requete attend de recevoir une requete SQL sous forme de string. $param attend un array avec les marqueurs associés à la valeur. Cet paramètre est  optionnel car on lui a affecté un array() vide par défaut.
    //Echapper les données de $param car elle proviennent de l'internaute : 
    foreach($param  as $indice=> $valeur){
        $param[$indice] =htmlspecialchars($valeur);// htmlspecialchars transforme les chevrons pour neutraliser les balises <script> </<script> et <style> (évite les failles XSS et CSS).         dans cette boucle. On prend à chaque tour de la valeur du tabaleau $param que 'lon échappe et que l'on réaffecte à son emplacementd'origine.
        //Requête préparée
     }
        global $pdo; // on accède à la variable globale $pdo qui est définie dans init.php à l'extérieur de cette de fonctions.
       
        $resultat = $pdo->prepare($requete); //on prépare la requête envoyée à notre fonction;

        //echo $requete;
        $succes = $resultat->execute($param);// puis on exécute la requête en lui passant le tableau qui contient les marqueurs et leur valeur pour faire les binParam().   $succes true si la requête à marché, sinon false;
        if($succes){
            return $resultat ; // si $succes contient true, donc que la requête a marché, je retourne le résultat de ma requête 
        } else{
            return false; //si la requête n'a pas marché on retourne false.
        }
      
    
}

function echappement($param)
{
    foreach($param  as $indice=> $valeur){
        $param[$indice] = htmlspecialchars($valeur);
        }
        return $param;
}
function selected($taille, $val){

    if ($taille == $val){
        echo 'selected';
    }
}

          
          