<a href="main.php?action=account" class="back-link">&larr; retour</a>

<section class="edit-book">
  <h1>Ajouter un livre</h1>

  <?php if (!empty($error ?? '')): ?>
    <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <div class="edit-card">
    <div class="edit-left">
      <label class="block-label">Photo</label>

      <!-- preview -->
      <div class="edit-photo-wrapper">
        <img id="previewBookImg" src="img/default-book.jpg" class="edit-photo" alt="">
      </div>

      <!-- input file -->
      <label class="edit-photo-link" style="cursor:pointer;">
        Modifier la photo
        <input id="bookPhotoInput" type="file" name="photo" accept="image/*" form="addBookForm" style="display:none;">
      </label>
    </div>

    <div class="edit-right">
      <form id="addBookForm" method="POST" action="index.php?action=addLivre" enctype="multipart/form-data" class="edit-form">
        <div class="form-row">
          <div class="field">
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" required
                   value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>">
          </div>

          <div class="field">
            <label for="auteur">Auteur</label>
            <input type="text" id="auteur" name="auteur" required
                   value="<?= isset($_POST['auteur']) ? htmlspecialchars($_POST['auteur']) : '' ?>">
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

<script>
  const input = document.getElementById('bookPhotoInput');
  const img = document.getElementById('previewBookImg');

  if (input) {
    input.addEventListener('change', (e) => {
      const file = e.target.files && e.target.files[0];
      if (!file) return;
      img.src = URL.createObjectURL(file);
    });
  }
</script>