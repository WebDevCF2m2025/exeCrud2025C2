<?php
# exeCrud2025C2/controller/PrivateController.php

// dépendances
require_once "../model/UserModel.php";
require_once "../model/ArticleModel.php";

if (isset($_GET['pg'])) {
    if ($_GET['pg'] === "disconnect") {
        // page de déconnexion
        disconnectUser();
        header("Location: ./");
        exit();
    } elseif ($_GET['pg'] === "about") {
        include "../view/about.html.php";
    } elseif ($_GET['pg'] === "admin") {
        $iduser = (int) $_SESSION['iduser'];
        if (isset($_POST['title'], $_POST['articletext'])) {
            $published = isset($_POST['articlepublished']) ? 1 : 0;
            $datePub = date('Y-m-d H:i:s');
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title'])));
            $insert = insertArticle($db, $_POST['title'], $slug, $_POST['articletext'], $iduser, $published, $datePub);

            if ($insert === true) {
                header("Location: ./");
                exit();
            } else {
                $error = "Echec lors de l'insertion";
            }
        }

        // Modification d'un article
        if(isset($_POST['edit_article_id'], $_POST['edit_article_title'], $_POST['edit_article_text'])){
            $published = isset($_POST['edit_article_is_published']) ? 1 : 0;
            $update = updateArticle($db, $_POST['edit_article_id'], $_POST['edit_article_title'], $_POST['edit_article_text'], $published);
            if($update){
                header("Location: ./?pg=admin");
                exit();
            }else{
                $error = "Echec lors de la modification";
            }
        }

        // Suppression d'un article
        if(isset($_POST['delete_article_id'])){
            $delete = deleteArticle($db, $_POST['delete_article_id']);
            if($delete){
                header("Location: ./?pg=admin");
                exit();
            }else{
                $error = "Echec lors de la suppression";
            }
        }
        $articles = getAllArticleAdmin($db);
        include "../view/admin.html.php";
    } else {
        $articles = getArticlesPublished($db);
        include "../view/homepage.html.php";
    }
} else {
    $articles = getArticlesPublished($db);
    // chargement de la page d'accueil
    include "../view/homepage.html.php";
}