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
  <?php 
?>

<?php
  require_once '../fonctions/login_fonction.php';
  $vendeursAbloquer = signalBlocage();
  foreach($vendeursAbloquer as $vendeur):
    echo"
    <div class='alert alert-warning d-flex justify-content-between align-items-center' role='alert'>
      <div>
        <strong>Attention!</strong> Le vendeur <strong>".$vendeur['id_vendeur']."</strong> a été signalé plusieurs fois.
      </div>
    </div>
    ";
    
  endforeach;
  ?>
  </div>
  <div class="d-flex justify-content-center my-4">
    <a href="ajtCategorie.php" class="btn" style="background-color:#001f3f; color:#fff; border-color:#001f3f;">Ajouter une catégorie</a>
  </div>
<div class="d-flex justify-content-center gap-2 my-3">
  <a href="ViewVendeur.php" class="btn btn-dark btn-sm">Liste Vendeurs</a>
  <a href="ViewClient.php" class="btn btn-light btn-sm border border-dark">Liste Clients</a>
</div>
</body>
<footer>
    <div class="text-center p-3">
        © <?php echo date("Y"); ?> Groupe Vente. Tous droits réservés.
    </div>
</footer>
</html>