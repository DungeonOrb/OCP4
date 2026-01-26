<section class="book-show">
  <div class="book-show-inner">


    <div class="book-show-left">
      <img src="<?= $livre->getImage() ?>" alt="<?= $livre->getTitre() ?>">
    </div>


    <div class="book-show-right">
      <h1><?= $livre->getTitre() ?></h1>
      <p class="book-show-author">par <?= $livre->getAuteur() ?></p>

      <div class="book-show-sep"></div>

      <h2 class="book-section-title">DESCRIPTION</h2>
      <p class="book-show-desc">
        <?= nl2br($livre->getContent()) ?>
      </p>

      <div class="book-owner-block">
        <h2 class="book-section-title">PROPRIÉTAIRE</h2>

        <?php if ($owner): ?>
  <?php
    $photo = $owner->getPhoto();
    $src = ($photo && $photo !== '') ? $photo : 'img/avatar-placeholder.png';
  ?>
  <a class="owner-pill" href="index.php?action=comptepublic&id=<?= $owner->getId() ?>">
    <img class="owner-avatar-img" src="<?= htmlspecialchars($src) ?>" alt="<?= $owner->getNom() ?>">
    <span><?= htmlspecialchars($owner->getNom()) ?></span>
  </a>
<?php endif; ?>
      </div>

      <?php if ($owner): ?>
        <a class="book-contact-btn" href="index.php?action=messages&to=<?= $owner->getId() ?>">
          Envoyer un message
        </a>
      <?php endif; ?>
    </div>

  </div>
</section>