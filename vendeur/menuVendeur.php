<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page vendeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>


<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PageVendeur</a>
            <div class="d-flex ms-auto">
                <a href="profilVendeur.php" class="btn btn-outline-primary">Profil</a>
            </div>
        </div>
    </nav>
</header>
<body>
    <div class="text-center mt-4">
        <h4>Produits</h4>
        <?php
require('../fonctions/login_fonction.php');
if($produits = getProduit()){
    foreach($produits as $produit){
        echo '<table class="table table-bordered table-striped w-75 mx-auto mb-4">
            <thead class="table-light">
            <tr>
                <th>Image</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Modifications</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><img src="' . htmlspecialchars($produit['image']) . '" alt="Produit" style="max-width:100px; max-height:100px;"></td>
                <td>' . htmlspecialchars($produit['description']) . '</td>
                <td>' . htmlspecialchars($produit['prix']) . ' €</td>
                <td>
                    <form action="#" method="post" name="modif_produit" style="display:inline;">
                        <button class="btn btn-outline-primary btn-sm" name="modif_produit">Modifier</button>
                    </form>
                    <form action="#" method="post" name="suppr_produit" style="display:inline;">
                        <button class="btn btn-outline-danger btn-sm" name="suppr_produit">Supprimer</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>';
            ;
    }
}

?>
<hr>
<br>
    <a href="ajtProduit.php" class="btn btn-success mt-2">Ajouter un produit</a>
    </div>
</body>
<footer class="bg-light text-center text-lg-start mt-auto">
    <div class="text-center p-3">
        © <?php echo date("Y"); ?> Groupe Vente. Tous droits réservés.
        <a href="../login/index.php" class="btn btn-outline-secondary btn-sm">Se déconnecter</a>
    </div>
</footer>
</html>