<a href="index.php?action=compte" class="back-link">&larr; retour</a>

<section class="edit-book">
  <h1>Modifier les informations</h1>

  <?php if (!empty($error)): ?>
    <p class="alert alert-error"><?= $error ?></p>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <p class="alert alert-success"><?= $success ?></p>
  <?php endif; ?>

  <div class="edit-card">
    <div class="edit-left">
      <label class="block-label">Photo</label>
      <div class="edit-photo-wrapper">
        <img src="<?= $livre->getImage() ?>" alt="" class="edit-photo">
      </div>
      <p class="edit-photo-link">Modifier la photo (plus tard)</p>
    </div>

    <div class="edit-right">
      <form method="POST" action="index.php?action=edit_livre&id=<?= $livre->getId() ?>" class="edit-form">
        <div class="form-row">
          <div class="field">
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre"
                   value="<?= $livre->getTitre() ?>" required>
          </div>

          <div class="field">
            <label for="auteur">Auteur</label>
            <input type="text" id="auteur" name="auteur"
                   value="<?= $livre->getAuteur() ?>" required>
          </div>
        </div>

        <div class="field">
          <label for="content">Commentaire</label>
          <textarea id="content" name="content" rows="10" required><?= $livre->getContent() ?></textarea>
        </div>

        <div class="field">
          <label for="dispo">Disponibilité</label>
          <select id="dispo" name="dispo">
            <option value="1" <?= $livre->getDispo() ? 'selected' : '' ?>>disponible</option>
            <option value="0" <?= !$livre->getDispo() ? 'selected' : '' ?>>non dispo.</option>
          </select>
        </div>

        <button type="submit" class="btn-primary">Valider</button>
      </form>
    </div>
  </div>
</section>