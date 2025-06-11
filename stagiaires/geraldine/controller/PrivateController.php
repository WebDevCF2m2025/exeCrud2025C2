<?php
# controller/PrivateController.php

if(!isset($_GET['pg'])){
    // chargement des articles pour l'accueil
    $articles = getArticles($db,true);
    // appel de la vue
    include "../view/homepage.html.php";
// page about
}elseif ($_GET['pg']==='about'){
    // appel de la vue
    include "../view/about.html.php";
// nous sommes sur la page de connexion
}elseif($_GET['pg']==="disconnect"){
        disconnectUser();
        header("Location: ./");
        exit();
    }elseif($_GET['pg']==="admin"){
        // si on a envoyé un nouvel article
        if(isset($_POST['title'])){
            $insert = addArticle($db,$_POST);
            if($insert){
                // retour sur l'admin avec le message de remerciement
                header("Location: ./?p=admin&message=Merci pour ce message");
                exit();
            }else{
                $error = "Erreur lors de l'insertion de l'article <a  href='#' onclick='history.go(-1);'>retour au formulaire</a>";
            }
        }
        include "../view/admin.html.php";
    }else{
        include "../view/404.html.php";
    }