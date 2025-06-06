<?php
# exeCrud2025C2/controller/PublicController.php

// dépendances
require_once "../model/UserModel.php";
require_once "../model/ArticleModel.php";

if (isset($_GET['pg'])) {
    if ($_GET['pg'] === "login") {
        // page de connexion
        if (isset($_POST["login"], $_POST["userpwd"])) {
            // tentative de connexion
            $connect = connectUser($db, $_POST["login"], $_POST["userpwd"]);
            if ($connect === true) {
                // redirection vers l'accueil
                header("Location: ./");
                exit();
            } else {
                $error = "Login et/ou mot de passe incorrect(s)";
            }
        }
        // appel du formulaire
        require_once "../view/login.html.php";
    } elseif ($_GET['pg'] === "about") {
        require_once "../view/about.html.php";
    } else {
        // toutes les autres valeurs de pg
        $articles = getArticlesPublished($db);
        require_once "../view/homepage.html.php";
    }
} else {
    $articles = getArticlesPublished($db);
    //chargement des articles pour l'accueil
    require_once "../view/homepage.html.php";
}