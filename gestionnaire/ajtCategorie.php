<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Catégorie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="mb-4">Ajouter une catégorie</h3>
                <form action="" method="post" name="ajt_categorie">
                    <div class="mb-3">
                        <label for="lib" class="form-label">Libellé :</label>
                        <input type="text" class="form-control" name="lib" id="lib" placeholder="Entrez le libellé de la catégorie">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                    <a href="menuGestion.php" class="btn btn-secondary ms-2">Retour</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
require_once('../fonctions/login_fonction.php');
if(isset($_POST['submit'])){
    array_pop($_POST);
    ajout_categorie($_POST);
    header('Location: menuGestion.php');
}