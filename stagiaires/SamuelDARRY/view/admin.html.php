<?php
// Correction : on redirige proprement si la session n'est plus valide
if (!isset($_SESSION['login'])) {
    header("Location: ./?pg=login");
    exit();
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MVC-CRUD-Procedural | Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="navbar navbar-expand-lg bg-white border-bottom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="./">
            <img src="https://www.cf2m.be/img/logo.png" alt="Logo CF2M" height="40" class="me-2">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
        <div class="navbar-nav ms-auto">
            <!-- Correction : usage cohérent de ?pg=... -->
            <a class="nav-link <?= !isset($_GET['pg']) ? 'active' : '' ?>" href="./">Accueil</a>
            <a class="nav-link <?= (isset($_GET['pg']) && $_GET['pg'] === 'about') ? 'active' : '' ?>" href="./?pg=about">À propos</a>
            <a class="nav-link <?= (isset($_GET['pg']) && $_GET['pg'] === 'admin') ? 'active text-primary' : '' ?>" href="./?pg=admin">Administration</a>
            <a class="nav-link text-danger" href="./?pg=disconnect">Déconnexion</a>
            <span class="nav-link text-muted d-none d-lg-inline">|</span>
            <span class="nav-link text-muted d-none d-sm-inline"><hr></span>
            <span class="text-muted small">
                Connecté : <?= htmlspecialchars($_SESSION['login']) ?><br>
            </span>
        </div>
        </div>
    </div>
</div>

<h1 class="mb-4 text-center">MVC-CRUD-Procedural | Accueil de l'administration</h1>
<div class="container">
    <div class="bg-white p-4 rounded shadow-sm mb-5">
        <h2 class="mb-3 text-center mb-5">Ajouter un article</h2>
        <!-- on affiche l'erreur -->
        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="" method="post" name="article">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" maxlength="160" required placeholder="Titre de l'article">
            </div>
            <div class="mb-3">
                <label for="articletext" class="form-label">Texte</label>
                <textarea class="form-control" id="articletext" name="articletext" rows="6" required placeholder="Votre texte"></textarea>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="articlepublished" name="articlepublished" value="1">
                <label class="form-check-label" for="articlepublished">Publier ?</label>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</div>
<div class="container my-5">
    <div class="bg-white p-3 p-md-4 rounded shadow-sm mb-5">
        <h2 class="text-center mb-5">Panneau de gestion des articles</h2>

        <!-- Affichage pour desktop -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle bg-white rounded">
                <thead class="table-light">
                <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Texte</th>
                    <th scope="col">Auteur</th>
                    <th scope="col">Date</th>
                    <th scope="col">Publié</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($articles as $article): ?>
                    <tr>
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $article['idarticle']): ?>
                            <form method="post">
                                <td>
                                    <input type="hidden" name="edit_article_id" value="<?= $article['idarticle'] ?>">
                                    <input type="text" class="form-control" name="edit_article_title" value="<?= htmlspecialchars($article['title']) ?>" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="edit_article_text" value="<?= htmlspecialchars($article['articletext']) ?>" required>
                                </td>
                                <td>
                                    <?= htmlspecialchars($article['username']) ?>
                                </td>
                                <td class="text-center">
                                    <?= htmlspecialchars($article['articledatepublished']) ?>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="edit_article_is_published" id="pub_<?= $article['idarticle'] ?>" <?= $article['articlepublished'] ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-success btn-sm mb-1">Enregistrer</button>
                                    <a href="?pg=admin" class="btn btn-outline-secondary btn-sm">Annuler</a>
                                </td>
                            </form>
                        <?php else: ?>
                            <td><?= htmlspecialchars($article['title']) ?></td>
                            <td><?= htmlspecialchars(mb_strimwidth($article['articletext'], 0, 60, '…')) ?></td>
                            <td><?= htmlspecialchars($article['username']) ?></td>
                            <td><?= htmlspecialchars($article['articledatepublished']) ?></td>
                            <td class="text-center">
                                <?= ($article['articlepublished'] ? "✅" : "❌") ?>
                            </td>
                            <td class="text-center">
                                <a href="?pg=admin&edit=<?= $article['idarticle'] ?>" class="btn btn-warning btn-sm mb-1">Modifier</a>
                                <form method="post" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                                    <input type="hidden" name="delete_article_id" value="<?= $article['idarticle'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Affichage carte mobile (sm uniquement) -->
        <div class="d-block d-md-none">
            <?php foreach ($articles as $article): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($article['username']) ?> — <?= htmlspecialchars($article['articledatepublished']) ?></h6>
                        <p class="card-text"><?= htmlspecialchars(mb_strimwidth($article['articletext'], 0, 100, '…')) ?></p>
                        <div class="mb-2">
                            <?= $article['articlepublished'] ? '<span class="badge bg-success">Publié</span>' : '<span class="badge bg-secondary">Non publié</span>' ?>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="?pg=admin&edit=<?= $article['idarticle'] ?>" class="btn btn-warning btn-sm flex-fill">Modifier</a>
                            <form method="post" class="flex-fill" onsubmit="return confirm('Confirmer la suppression ?');">
                                <input type="hidden" name="delete_article_id" value="<?= $article['idarticle'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm w-100">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>