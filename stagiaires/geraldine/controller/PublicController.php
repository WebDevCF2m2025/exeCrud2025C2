<?php
# controller/PublicController.php
require_once "../model/ArticleModel.php";
require_once "../model/UserModel.php";

if(isset($_GET['pg'])){
    if($_GET['pg']==="login"){
        // ici tentative de connexion
        if(isset($_POST['login']) && isset($_POST['userpwd'])){
            $connect = connectUser($db,$_POST['user_login'],$_POST['user_pwd']);
            if($connect===true){
                header("Location: ./");
                exit();
            }
        }

        // appel de la vue
        require_once "../view/login.html.php";
    }
}else {
    //chargement des articles pour l'accueil
    $articles = getArticlesPublished($db);
    require_once "../view/homepage.html.php";
}