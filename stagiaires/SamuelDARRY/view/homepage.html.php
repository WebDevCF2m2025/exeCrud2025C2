<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MVC-CRUD-Procedural | Accueil</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="./">
            <img src="https://www.cf2m.be/img/logo.png" alt="Logo CF2M" height ="40" class="me-2">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <div class="navbar-nav ms-auto">
                <a class="nav-link <?= !isset($_GET['pg']) ? 'active text-primary' : '' ?>" href="./">Accueil</a>
                <a class="nav-link <?= (isset($_GET['pg']) && $_GET['pg'] === 'about') ? 'active' : '' ?>" href="./?pg=about">À propos</a>
                <?php if(isset($_SESSION['login'])): ?>
                    <a class="nav-link <?= (isset($_GET['pg']) && $_GET['pg'] === 'admin') ? 'active' : '' ?>" href="./?pg=admin">Administration</a>
                    <a class="nav-link text-danger" href="./?pg=disconnect">Déconnexion</a>
                    <span class="nav-link text-muted d-none d-lg-inline">|</span>
                    <span class="nav-link text-muted d-none d-sm-inline"><hr></span>
                    <span class="text-muted small">
                        Connecté : <?=$_SESSION['login']?><br>
                    </span>
                <?php else: ?>
                    <a class="nav-link <?= (isset($_GET['pg']) && $_GET['pg'] === 'login') ? 'active' : '' ?>" href="./?pg=login">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>


<h1 class="mb-4 text-center">MVC-CRUD-Procedural | Accueil</h1>
<div class="container mb-4">
    <div class="bg-white p-4 rounded shadow-sm">
        <h2 class="mb-1 text-center">Nos derniers articles</h2>
        <?php if(empty($articles)): ?>
            <div class="alert alert-info">Pas encore d'articles</div>
        <?php else:
            $nbArticles = count($articles);
            $pluriel = $nbArticles > 1 ? "s" : "";
            ?>
            <p class="text-secondary text-center mb-5">Nous avons <?=$nbArticles?> article<?=$pluriel?></p>
            <?php foreach($articles as $article): ?>
            <div class="mb-4 pb-3 border-bottom">
                <h4 class="mb-2"><?=$article['title']?></h4>
                <p class="mb-1"><?=substr($article['articletext'],0,200)?>...<a class="link-secondary" href="#"> Lire la suite</a></p>
                <div class="text-muted small">
                    Publié le <?= dateFR($article['articledatepublished'])?> par <?=$article['username']?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>