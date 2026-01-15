<section class="books">
  <div class="books-inner">

    <div class="books-header">
      <h1>Nos livres à l’échange</h1>

      <form class="search-bar" method="GET" action="index.php">
        <input type="hidden" name="action" value="livres">
        <input
          type="text"
          name="q"
          placeholder="Rechercher un livre"
          value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>"
        >
        <button type="submit">Rechercher</button>
      </form>
    </div>

    <?php if (empty($livres)): ?>
      <p>Aucun livre ne correspond à votre recherche.</p>
    <?php endif; ?>

    <div class="books-grid">
      <?php foreach ($livres as $livre): ?>
        <a class="book-link" href="index.php?action=livre&id=<?= $livre->getId() ?>">
          <article class="book-card">
            <div class="book-image-wrapper">
              <img src="<?= $livre->getImage() ?>" alt="">
            </div>

            <div class="book-body">
              <h2><?= $livre->getTitre() ?></h2>
              <p class="author"><?= $livre->getAuteur() ?></p>
              <p class="seller">Vendu par : <?= $livre->getVendeurNom() ?></p>
            </div>
          </article>
        </a>
      <?php endforeach; ?>
    </div>

  </div>
</section>