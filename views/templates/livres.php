<form class="search-bar" method="GET" action="index.php">
    <input type="hidden" name="action" value="livres">
    <input type="text" name="q" placeholder="Rechercher un livre"
           value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
    <button type="submit">Rechercher</button>
</form>

<?php if (empty($livres)): ?>
    <p>Aucun livre ne correspond à votre recherche.</p>
<?php endif; ?>

<div class="books-grid">
    <?php foreach ($livres as $livre): ?>
    <a class="book-link" href="index.php?action=livre&id=<?= $livre->getId() ?>">
        <article class="book-card">
            <img src="<?= $livre->getImage() ?>" alt="">
            <h2><?= $livre->getTitre() ?></h2>
            <p class="author"><?= $livre->getAuteur() ?></p>
            <p class="seller">Vendu par : <?= (string)$livre->getVendeur() ?></p>
        </article>
    </a>
<?php endforeach; ?>
</div>