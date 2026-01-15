<section class="account">
  <h1>Mon compte</h1>

  <?php if (!empty($error)): ?>
    <p class="alert alert-error"><?= $error ?></p>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <p class="alert alert-success"><?= $success ?></p>
  <?php endif; ?>

  <div class="account-top">
    <!-- carte profil -->
    <div class="card profile-card">
      <div class="avatar">
        <?php
        // si photo null => placeholder
        $photo = method_exists($user, 'getPhoto') ? $user->getPhoto() : null;
        ?>
        <img src="<?= $photo ? $photo : 'img/books.png' ?>" alt="">
        <a class="edit-photo" href="#" onclick="document.getElementById('photoInput').click(); return false;">modifier</a>

<form action="index.php?action=uploadphoto" method="POST" enctype="multipart/form-data" style="display:none;">
  <input id="photoInput" type="file" name="photo" accept="image/*"
         onchange="this.form.submit()">
</form>
      </div>

      <div class="profile-sep"></div>

      <div class="profile-meta">
        <h2><?= $user->getNom() ?></h2>
        <p class="muted">Bibliothèque</p>
        <p class="count"><?= count($livres) ?> livres</p>
      </div>
    </div>

    <!-- édition -->
    <div class="card form-card">
      <h3>Vos informations personnelles</h3>

      <form method="POST" action="index.php?action=updatecompte" class="account-form">
        <label>
          <span>Adresse email</span>
          <input type="email" name="email" required value="<?= $user->getEmail() ?>">
        </label>

        <label>
          <span>Mot de passe</span>
          <input type="password" name="password">
        </label>

        <label>
          <span>Pseudo</span>
          <input type="text" name="nom" required maxlength="35" value="<?= $user->getNom() ?>">
        </label>

        <button class="btn-outline" type="submit">Enregistrer</button>
      </form>
    </div>
  </div>

  <!-- tableau livres -->
   <a href="index.php?action=addLivre" class="btn-outline" style="margin-bottom:18px;display:inline-block;">
    Ajouter un livre
</a>
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
              <img src="<?= $livre->getImage() ?>" alt="">
            </td>
            <td><?= $livre->getTitre() ?></td>
            <td><?= $livre->getAuteur() ?></td>
            <td class="td-desc"><?= $livre->getContent(70) ?></td>
            <td>
              <?php if ((int)$livre->getDispo() === 1): ?>
                <span class="badge badge-ok">disponible</span>
              <?php else: ?>
                <span class="badge badge-no">non dispo.</span>
              <?php endif; ?>
            </td>
            <td class="td-actions">
              <a href="index.php?action=editLivre&id=<?= $livre->getId() ?>">Éditer</a>
              <a class="danger" href="index.php?action=delete_livre&id=<?= $livre->getId() ?>">Supprimer</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>