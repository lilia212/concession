<?php

//Connexion à la BDD "repertoire"
$pdo = new PDO('mysql:host=localhost; dbname=concession','root', '', array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

//test session start

//Session 
session_start();
// Constante qui contient le chemin du site
define('RACINE_SITE', '/PHP/Concession/' ); 

//Initialisation d'une variable pour afficher du contenu HTML: 
$contenu='';

//Inclusions de fonctions :
require_once 'functions.php';
