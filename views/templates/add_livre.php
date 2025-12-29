<a href="main.php?action=compte" class="back-link">&larr; retour</a>

<section class="edit-book">
  <h1>Ajouter un livre</h1>

  <?php if (!empty($error)): ?>
    <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <div class="edit-card">
    <div class="edit-left">
      <label class="block-label">Photo</label>
      <div class="edit-photo-wrapper">
        <!-- placeholder / image par défaut -->
        <img src="img/default-book.jpg" alt="" class="edit-photo">
      </div>
      <p class="edit-photo-link">Image (a faire plus tard).</p>
    </div>

    <div class="edit-right">
      <form method="POST" action="main.php?action=add_livre" class="edit-form">
        <div class="form-row">
          <div class="field">
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre"
                   value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>" required>
          </div>

          <div class="field">
            <label for="auteur">Auteur</label>
            <input type="text" id="auteur" name="auteur"
                   value="<?= isset($_POST['auteur']) ? htmlspecialchars($_POST['auteur']) : '' ?>" required>
          </div>
        </div>

        <div class="field">
          <label for="content">Commentaire</label>
          <textarea id="content" name="content" rows="10" required><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>
        </div>

        <div class="field">
          <label for="dispo">Disponibilité</label>
          <select id="dispo" name="dispo">
            <option value="1" <?= (isset($_POST['dispo']) && $_POST['dispo'] == '0') ? '' : 'selected' ?>>disponible</option>
            <option value="0" <?= (isset($_POST['dispo']) && $_POST['dispo'] == '0') ? 'selected' : '' ?>>non dispo.</option>
          </select>
        </div>

        <button type="submit" class="btn-primary">Valider</button>
      </form>
    </div>
  </div>
</section>