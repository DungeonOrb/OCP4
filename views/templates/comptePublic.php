<section class="profile">
  <div class="profile-grid">

    <div class="card profile-card">
      <div class="avatar">
        <?php

          $photo = method_exists($user, 'getPhoto') ? $user->getPhoto() : null;
        ?>
        <img src="<?= $photo ?  $photo : 'img/avatar-placeholder.png' ?>" alt="">
      </div>

      <div class="profile-sep"></div>

      <h2 class="profile-name"><?=  $user->getNom() ?></h2>
      <p class="muted">Membre depuis 1 an</p> 

      <div class="mini">
        <span class="mini-label">BIBLIOTHÈQUE</span>
        <span class="mini-value"><?= count($livres) ?> livres</span>
      </div>

      <a class="btn-outline" href="index.php?action=messages&to=<?= $user->getId() ?>">
    Écrire un message
</a>
    </div>


    <div class="card table-card">
      <table class="books-table">
        <thead>
          <tr>
            <th>PHOTO</th>
            <th>TITRE</th>
            <th>AUTEUR</th>
            <th>DESCRIPTION</th>
          </tr>
        </thead>

        <tbody>
        <?php foreach ($livres as $livre): ?>
          <tr>
            <td class="td-photo">
              <img src="<?=  $livre->getImage() ?>" alt="">
            </td>
            <td><?=  $livre->getTitre() ?></td>
            <td><?=  $livre->getAuteur() ?></td>
            <td class="td-desc"><?=  $livre->getContent(90) ?></td>
          </tr>
        <?php endforeach; ?>

        <?php if (empty($livres)): ?>
          <tr>
            <td colspan="4" class="empty">Aucun livre disponible pour le moment.</td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>