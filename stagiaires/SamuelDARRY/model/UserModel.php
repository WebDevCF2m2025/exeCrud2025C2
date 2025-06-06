<?php
# exeCrud2025C2/model/UserModel.php

function connectUser(PDO $con, string $userLogin, string $userPwd): bool
{
    // par sécurité (extrême) sur les sessions
    // en cas de tentative de reconnexion, on supprime
    // l'ancienne session (cookie + fichier texte)
    // et on régénère un identifiant
    session_regenerate_id(true);
    // on supprime la copie des datas dans le nouveau fichier
    session_unset();
    // on récupère l'utilisateur via son login
    // le mot de passe doit être vérifié côté PHP
    // requête préparée que sur le login (champ unique)
    $sql = ("SELECT * FROM `user` WHERE `login`= ?");

    // requête préparée
    $prepare = $con->prepare($sql);
    try{
        $prepare->execute([$userLogin]);
        // on a récupéré personne
        if($prepare->rowCount()!==1) return false;
        // on a donc UN utilisateur (champ unique),
        $user = $prepare->fetch();
        // bonne pratique
        $prepare->closeCursor();
        // on va vérifier son mot de passe
        // entre celui passé par le formulaire et celui venant de la DB
        if(password_verify($userPwd,$user['userpwd'])){
            // on met en session tout ce qu'on a été récupéré de la requête
            $_SESSION = $user;
            // suppression du mot de passe
            unset($_SESSION['userpwd']);
            return true;
        }else{
            return false;
        }

    }catch (Exception $e){
        die($e->getMessage());
    }
}

function disconnectUser(): void
{
    # suppression des variables de sessions
    session_unset();

    # suppression du cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    # Destruction du fichier lié sur le serveur
    session_destroy();
}