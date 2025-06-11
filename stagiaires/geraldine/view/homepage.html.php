<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="./">Accueil</a></li>
        <li><a href="./?pg=login">Connexion</a></li>
    </ul>
</nav>
    <h1>Accueil du site</h1>
    <div id="content">
<p>Bienvenue sur notre site web !</p>
        <?php
if(empty($articles)):
        ?>
        <h3>Pas encore d'articles</h3>
        <?php
else:
    $nbArticles = count($articles);
    $pluriel = $nbArticles>1? "s":"";
        ?>
        <h3>Il y a <?=$nbArticles?>  article<?=$pluriel?> actuellement sur le site</h3>
        <?php
    foreach($articles as $article):
        ?>
        <div class="article">
            <h2><a href="?pg=article&slug=<?php echo $article['slug']; ?>"><?php echo $article['title']; ?></a></h2>
            <h3>Ecrit par <?php echo $article['username']; ?> le <?php echo $article['articledatepublished']; ?></h3>
            <p><?php echo $article['articletext']; ?>... <a href="?pg=article&slug=<?php echo $article['slug']; ?>">Lire la suite</a></p>

        </div>
        <?php
    endforeach;
endif;
        ?>
    </div>
</body>
</html>