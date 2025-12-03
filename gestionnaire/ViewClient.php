<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>ViewClient</title>
</head>
<header>
    <div class="bg-dark text-white text-center py-2 mb-3">
        <h5 class="mb-0 d-inline-block">Liste Client</h5>
        <div class="float-end">
            <a href="menuGestion.php" class="btn btn-outline-light btn-sm me-2" role="button" aria-label="Menu">Menu</a>
            <a href="ajtCategorie.php" class="btn btn-outline-light btn-sm me-2" role="button" aria-label="Ajouter Catégorie">Ajouter Catégorie</a>
            <a href="ViewVendeur.php" class="btn btn-outline-light btn-sm" role="button" aria-label="Liste vendeurs">Liste vendeurs</a>
        </div>
    </div>
</header>
<body>
    <?php require "../fonctions/login_fonction.php";
$clients = getclient();
?>
<table class="table table-striped table-hover table-bordered table-sm align-middle">
    <thead class="table-dark">
        <tr class="text-center">
            <th class="px-3">Nom</th>
            <th class="px-3">Prénom</th>
            <th class="px-3">email</th>
            <th class="px-3">Téléphone</th>
        </tr>
    <tbody>
        <tr class="text-center">
            <?php foreach($clients as $client): ?>
            <td class="px-2 text-center"><?php echo $client['nom']; ?></td>
            <td class="px-2 text-center"><?php echo $client['prenom']; ?></td>
            <td class="px-2 text-center"><?php echo $client['email']; ?></td>
            <td class="px-2 text-center"><?php echo $client['phone']; ?></td>
        </tr>
            <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>