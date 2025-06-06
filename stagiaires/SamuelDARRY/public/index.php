<?php
# exemple5MVC/public/index.php

/*
 * Contrôleur frontal
 */

// Création de la session
session_start();

// dépendances
require_once "../config-prod.php";

// notre connexion PDO
try{
    // instanciation de PDO
    $db = new PDO(DB_DSN,DB_LOGIN,DB_PWD);
    // par défaut, on obtient des tableaux associatifs
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    // on active l'affichage des erreurs
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


}catch(Exception $e){
    die($e->getMessage());
}


// si nous sommes connectés
if(isset($_SESSION['login'])) {
    // nous prenons le contrôleur privé
    require_once "../controller/PrivateController.php";

// non connectés
}else {
    // chargement du routeur public
    require_once "../controller/PublicController.php";
}

// ici nos contrôleurs

// echo '<h4>session_id() ou SID</h4>';
// var_dump(session_id());
// echo '<h4>$_GET</h4>';
// var_dump($_GET);
// echo '<h4>$_SESSION</h4>';
// var_dump($_SESSION);
// echo '<h3>$_POST</h3>';
// var_dump($_POST);


// bonne pratique
$db = null;