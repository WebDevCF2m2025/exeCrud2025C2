<?php
# exeCrud2025C2/model/ArticleModel.php
function getArticlesPublished(PDO $connect): array
{
    // Préparation de la requête
    $sql = "
        SELECT a.`idarticle`, a.`title`, a.`slug`, LEFT(a.`articletext`,300) AS `articletext`, 
               a.`articlepublished`, a.`articledatepublished`, 
               u.`login`, u.`username`
        FROM `article` a 
            INNER JOIN `user` u ON a.`user_iduser` = u.`iduser`
        WHERE a.`articlepublished` = 1 
        ORDER BY a.`articledatepublished` DESC
    ";
    try{
        $query = $connect->query($sql);
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;
    }catch (Exception $e){
        die($e->getMessage());
    }
}

// Fonction pour tout voir en admin
function getAllArticleAdmin(PDO $con):array
{
    $sql = "
    SELECT a.`idarticle`, a.`title`, a.`articletext`, a.`articledatecreated`, a.`articledatepublished`, a.`articlepublished`, u.`username`
    FROM `article` a
    INNER JOIN `user` u ON u.`iduser` = a.`user_iduser`
    ORDER BY a.`articledatepublished` DESC;
    ";
    try{
        $query = $con->query($sql);
        $result = $query->fetchAll();
        $query->closeCursor();
        return $result;
    }catch (Exception $e){
        die($e->getMessage());
    }
}


function insertArticle(PDO $connect, string $title, string $slug, string $text, int $userId, int $published, string $datePub): bool
{
    // Sécurisation des données utilisateurs
    $titre = htmlspecialchars(strip_tags(trim($title)), ENT_QUOTES);
    $texte = htmlspecialchars(strip_tags(trim($text)), ENT_QUOTES);

    if (empty($titre) || strlen($titre) > 160 || empty($texte)) return false;

    $sql = "INSERT INTO article (title, slug, articletext, user_iduser, articlepublished, articledatepublished) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $prepare = $connect->prepare($sql);
    try {
        $prepare->execute([$titre, $slug, $texte, $userId, $published, $datePub]);
        return true;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

// Modifier un article
function updateArticle(PDO $db, $id, $title, $text, $published) {

    // Sécurisation des données utilisateurs
    $titre = htmlspecialchars(strip_tags(trim($title)), ENT_QUOTES);
    $texte = htmlspecialchars(strip_tags(trim($text)), ENT_QUOTES);
    if (empty($titre) || strlen($titre) > 160 || empty($texte)) return false;

    $sql = "UPDATE article SET title=?, articletext=?, articlepublished=? WHERE idarticle=?";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$titre, $texte, $published, $id]);
}

// Supprimer un article
function deleteArticle(PDO $db, $id) {
    $sql = "DELETE FROM article WHERE idarticle=?";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$id]);
}



function dateFR(string $datetime): string
{
    // Temps unix en seconde de la date venant de la db
    $stringtotime = strtotime($datetime);

    // Retour de la date au format
    return date("d/m/Y \à H\hi",$stringtotime);
}
