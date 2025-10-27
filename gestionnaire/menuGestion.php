<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PageGestion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Page gestionnaire</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
        

    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="../login/index.php" class="btn btn-outline-secondary btn-sm">Se déconnecter</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<body>
  <div class="d-flex justify-content-center my-4">
    <a href="ajtCategorie.php" class="btn btn-primary">Ajouter une catégorie</a>
  </div>
<?php  require('../fonctions/login_fonction.php');
array_pop($_POST);
$user = getUtilisateur();
?>


    <div class="container my-5">
      <h2 class="text-center mb-4">Liste des utilisateurs</h2>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Email</th>
              <th>Téléphone</th>
              <th>Adresse</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($user) && is_array($user)): ?>
              <?php foreach ($user as $u): ?>
                <tr>
                  <td><?php echo htmlspecialchars($u['nom'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($u['prenom'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($u['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($u['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($u['adresse'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">Aucun utilisateur trouvé.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
<?php ; ?>
        </div>
    </div>
 
</body>
<footer>
    <div class="text-center p-3">
        © <?php echo date("Y"); ?> Groupe Vente. Tous droits réservés.
    </div>
</footer>
</html>