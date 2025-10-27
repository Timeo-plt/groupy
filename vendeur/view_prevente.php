<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViewPrevente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Préventes</a>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="menuVendeur.php">Accueil</a></li>
                </ul>
                <ul class="navbar-nav ms-3">
                    <li class="nav-item"><a class="nav-link" href="profilVendeur.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="../login/index.php">Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>
<?php require('../fonctions/login_fonction.php'); 
$preventes = getprevente();
?>
<table class="table table-striped table-hover table-bordered align-middle">
    <thead class="table-primary">
        <th class="text-center">date de fin</th>
        <th class="text-center">Participants</th>
        <th class="text-center">statut</th>
        <th class="text-center">prix à la prevente</th>
        <th class="text-center">produits</th>
    </thead>
    <tbody>
<?php foreach($preventes as $prevente): ?>
<?php $prodP =  produit_prevente();
foreach($prodP as $pp): ?>
    <tr>
        <td class="text-center"><?php echo htmlspecialchars($prevente['date_limite']); ?></td>
        <td class="text-center"><?php echo htmlspecialchars($prevente['nombre_min']); ?></td>
        <td class="text-center"><?php echo htmlspecialchars($prevente['statut']); ?></td>
        <td class="text-center"><?php echo htmlspecialchars($prevente['prix_prevente']); ?> €</td>
        <td class="text-center"><?php echo htmlspecialchars($pp['description']); ?></td>
<?php endforeach; ?>
<?php endforeach; ?>
  </tr>
</tbody>
</table>
</body>
</html>