<section class="account">
  <h1>Mon compte</h1>

  <?php if (!empty($error)): ?>
    <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <p class="alert alert-success"><?= htmlspecialchars($success) ?></p>
  <?php endif; ?>

  <div class="account-top">
    <!-- Carte profil -->
    <div class="card profile-card">
      <div class="avatar">
        <?php
          // si photo null => placeholder
          $photo = method_exists($user, 'getPhoto') ? $user->getPhoto() : null;
        ?>
        <img src="<?= $photo ? htmlspecialchars($photo) : 'img/avatar-placeholder.png' ?>" alt="">
        <a class="edit-photo" href="#">modifier</a>
      </div>

      <div class="profile-sep"></div>

      <div class="profile-meta">
        <h2><?= htmlspecialchars($user->getNom()) ?></h2>
        <p class="muted">Bibliothèque</p>
        <p class="count"><?= count($livres) ?> livres</p>
      </div>
    </div>

    <!-- Carte édition -->
    <div class="card form-card">
      <h3>Vos informations personnelles</h3>

      <form method="POST" action="main.php?action=account_update" class="account-form">
        <label>
          <span>Adresse email</span>
          <input type="email" name="email" required value="<?= htmlspecialchars($user->getEmail()) ?>">
        </label>

        <label>
          <span>Mot de passe</span>
          <input type="password" name="password" placeholder="Laisser vide pour ne pas changer">
        </label>

        <label>
          <span>Pseudo</span>
          <input type="text" name="nom" required maxlength="35" value="<?= htmlspecialchars($user->getNom()) ?>">
        </label>

        <button class="btn-outline" type="submit">Enregistrer</button>
      </form>
    </div>
  </div>

  <!-- Tableau livres -->
  <div class="card table-card">
    <table class="books-table">
      <thead>
        <tr>
          <th>PHOTO</th>
          <th>TITRE</th>
          <th>AUTEUR</th>
          <th>DESCRIPTION</th>
          <th>DISPONIBILITÉ</th>
          <th>ACTION</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($livres as $livre): ?>
        <tr>
          <td class="td-photo">
            <img src="<?= htmlspecialchars($livre->getImage()) ?>" alt="">
          </td>
          <td><?= htmlspecialchars($livre->getTitre()) ?></td>
          <td><?= htmlspecialchars($livre->getAuteur()) ?></td>
          <td class="td-desc"><?= htmlspecialchars($livre->getContent(70)) ?></td>
          <td>
            <?php if ((int)$livre->getDispo() === 1): ?>
      <span class="badge badge-ok">disponible</span>
  <?php else: ?>
      <span class="badge badge-no">non dispo.</span>
  <?php endif; ?>
          </td>
          <td class="td-actions">
            <a href="main.php?action=edit_livre&id=<?= $livre->getId() ?>">Éditer</a>
            <a class="danger" href="main.php?action=delete_livre&id=<?= $livre->getId() ?>">Supprimer</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>