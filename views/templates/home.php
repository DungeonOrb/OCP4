<section class="hero">
    <div class="hero-left">
        <h1>Rejoignez nos lecteurs passionnés</h1>
        <p>
            Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture.
            Nous croyons en la magie du partage de connaissances et d'histoire à travers les livres.
        </p>
        <a href="#" class="green-button">Découvrir</a>
    </div>

    <div class="hero-right">
        <img src="./img/tasdelivres.png" alt="Livres" class="hero-img">
    </div>
</section>


<section class="latest-books">
  <div class="latest-inner">
    <h2>Les derniers livres ajoutés</h2>

    <div class="latest-grid">
      <?php foreach ($livres as $livre): ?>
        <a class="book-link" href="index.php?action=livre&id=<?= $livre->getId() ?>">
          <article class="book-card">
            <div class="book-image-wrapper">
              <img src="<?= $livre->getImage() ?>" alt="<?= $livre->getTitre() ?>">
            </div>

            <div class="book-body">
              <h3><?= $livre->getTitre() ?></h3>
              <p class="author"><?= $livre->getAuteur() ?></p>
              <p class="seller">Vendu par : <?= $livre->getVendeurNom() ?></p>
            </div>
          </article>
        </a>
      <?php endforeach; ?>
    </div>

    <a href="index.php?action=livres" class="green-button">Voir tous les livres</a>
  </div>
</section>


<section class="how-it-works">
    <h2>Comment ça marche ?</h2>
    <p>Échanger des livres avec TomTroc est simple et amusant ! Suivez ces étapes pour commencer :</p>

    <div class="steps">
        <div class="step">Inscrivez-vous grauitement sur notre plateforme.</div>
        <div class="step">Ajoutez les livres que vous souhaitez échanger à votre profil.</div>
        <div class="step">Parcourez les livres disponibles chez d'autres membres.</div>
        <div class="step">Proposez un échange et discutez avec d'autres passionnés de lecture.</div>
    </div>

    <a href="index.php?action=livres" class="green-button">Voir tous les livres</a>
</section>

<img src="./img/bookbanner.png" alt="Livres" class="banner">

<section class="valeur">
    <div class="content">
    <h2>Nos valeurs</h2>
    <p>Chez Tom Troc, nous mettons l'accent sur le partage, la découverte
        et la communauté. Nos valeurs sont ancrées dans notre passion pour
        les livres et notre désir de créer des liens entre les lecteurs.
        Nous croyons en la puissance des histoires pour rassembler les gens
        et inspirer des conversations enrichissantes.</p>
        <p>
            Notre association a été fondée avec une conviction profonde :
            chaque livre mérite d'être lu et partagé.
        </p>
        <p>
            Nous sommes passionnés par la création d'une plateforme conviviale
            qui permet aux lecteurs de se connecter, de partager leurs
            découvertes littéraires et d'échanger des livres qui attendent
            patiemment sur les étagères.
        </p>
        <span class="signature">L’équipe Tom Troc</span>
        </div>


</section>