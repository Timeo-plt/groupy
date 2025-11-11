<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PageClient</a>
            <div class="d-flex ms-auto">
                <a href="profilClient.php" class="btn btn-outline-primary">Profil</a>
            </div>
            <a href="../login/index.php" class="btn btn-outline-secondary btn-sm">Se déconnecter</a>
        </div>
    </nav>
</header>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Liste des produits</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
<?php
require('../fonctions/login_fonction.php');


if($preventeClient = preventClient()){
    foreach($preventeClient as $produit){
        echo "<div class='col'>
                <div class='card h-100'>
                    <div class='card-body'>
                        <h5 class='card-title'>".$produit['image']."</h5>
                        <p class='card-text'>".$produit['description']."</p>   
                        <p class='card-text fw-bold'>Prix: ".$produit['prix']."</p>
                        <p class='card-text fw-bold'>Prix de la prevente : ".$produit['prix_prevente']."</p>
                        <p class='card-text fw-bold'>Statut de la prevente : ".$produit['statut']."</p>
                        <form method='POST' action=''>
                        <input type='hidden' name='id_client' value='".$_SESSION['connectedUser']['id_user']."'>
                        <input type='hidden' name='id_prevente' value='".$produit['id_prevente']."'>
                        <button type='submit' name='participer' class='btn btn-primary'>Participer</button>
                        </form>
                        <a href='#' class='btn btn-danger'>signaler</a>
                    </div>
                </div>
            </div>
        ";
    }
}
?>
</body>
<footer class="bg-light text-center text-lg-start mt-auto w-100" style="position: fixed; bottom: 0; left: 0;">
    <div class="text-center p-3">
        © <?php echo date("Y"); ?> Groupe Vente. Tous droits réservés.
    </div>
</footer>
</html>
<?php
if(isset($_POST['participer'])){
    array_pop($_POST);
    participation($_POST);
    header('Location: menuClient.php');
}
?>