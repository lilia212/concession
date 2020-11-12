<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
    <title>Concession des voitures</title>
    <style>

  
      h2{
          border-top: 1px solid navy;
          border-bottom: 1px solid navy;
          color: navy;
      }
      table{
          border-collapse: collapse;
      }
      td, th, .border{
      
          border-bottom: 1px solid black; 
       
          
      }     
    .loader{
      background-image: url("photo/loader.gif") ;
      background-repeat: no-repeat;
      width: 100px;
      height:40px;
    }
    .page-link{
      color:#20252b;
    }
    .page-item.active{
      background-color: #20252b;
      border-color: #20252b;
    }
    header{
    background-image: url("photo/header.jpg") ;
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
    height: 700px;

    }
    .img {
     
      width: 100%;
      height: 220px;
    }
    
 </style>
 
  </head>
  <body>
  
    <!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
   
   <div class="container">
        <!--La marque-->
        <a class="navbar-brand" href="<?php echo RACINE_SITE . 'index.php' ;?>">Accueil</a>
        <!--burger-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!--Menu de navigation-->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              
            <?php
                 $page = $_SERVER['REQUEST_URI'];
                 $page = str_replace("/PHP/Concession/", "",$page);
                 
                 ($page == "ajout_voiture.php") ? $active="active" : $active="";
                  echo '<li><a class="nav-link '.$active.'" href="'. RACINE_SITE .'ajout_voiture.php">Ajout Voiture</a></li>';
                
                  if(estConnecte()){// si le membre est connecté
                  ($page == "profil.php") ? $active="active" : $active="";
                  echo '<li><a class="nav-link '.$active.'" href="'. RACINE_SITE .'profil.php">Profil</a></li>';
                  
                  ($page == "connexion.php") ? $active="active" : $active="";
                  echo '<li><a class="nav-link '.$active.'" href="'. RACINE_SITE .'connexion.php?action=deconnexion">Déconnexion</a></li>';
               
                }else{// sinon le membre n'est pas connecté
                  ($page == "inscription.php") ? $active="active" : $active="";
                  echo '<li><a class="nav-link '.$active.'" href="'. RACINE_SITE .'inscription.php">Inscription</a></li>';
                  
                  (strstr($page,"connexion.php")) ? $active="active" : $active="";
                  echo '<li><a class="nav-link '.$active.'" href="'. RACINE_SITE .'connexion.php">Connexion</a></li>';
                 }
                 if(estAdmin()) { // si le membre est admin connecté
                  (strstr($page,"admin/index.php")) ? $active="active" : $active="";
                  echo '<li><a class="nav-link '.$active.'" href="'. RACINE_SITE .'admin/index.php">Gestion des voitures</a></li>'; 
                  
                  ($page == "admin/gestion_membre.php") ? $active="active" : $active="";
                  echo '<li><a class="nav-link '.$active.'" href="'. RACINE_SITE .'admin/gestion_membre.php">Gestion des membres</a></li>'; 
                } 
                ($page == "contact.php") ? $active="active" : $active=""; 
                echo '<li><a class="nav-link '.$active.'" href="'. RACINE_SITE .'contact.php">Contact</a></li>';  
              ?>  
            </ul>
        </div>
    </div><!-- .container-->
</nav>




<!--Contenu de la page -->
  <main style="min-height:80vh;">

    