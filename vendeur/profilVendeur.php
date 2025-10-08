<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<?php
require_once('../fonctions/login_fonction.php');
if($_SESSION['connectedUser']){
    $data=$_SESSION['connectedUser'];
    array_pop($data);
    $nom = $data['nom'];
    $prenom = $data['prenom'];
    $adresse = $data['adresse'];
    $phone = $data['phone'];
    $email = $data['email'];
    $motdepasse = $data['motdepasse'];
    $nom_entreprise = $data['nom_entreprise'];
    $siret = $data['siret'];
    $adresse_entreprise = $data['adresse_entreprise'];
    $email_pro = $data['email_pro'];
}

?>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Profil Client</h4>
                    </div>
                    <div class="card-body text-center">
                        <img src="https://via.placeholder.com/120" class="rounded-circle mb-3" alt="Photo de profil">
                        <h5 class='card-title'>Nom: <?php echo $nom?></h5>
                        <h5 class='card-title'>Prenom: <?php echo $prenom ?></h5>
                        <p class='card-title'>Adresse: <?php echo $adresse ?></p>
                        <p class='card-title'>Numéro de tel: <?php echo $phone ?></p>
                        <p class='card-title'>Adresse mail:<?php echo $email ?></p>
                        <p class='card-title'>Mot de passe: <?php echo $motdepasse ?></p>
                        <p class='card-title'>Nom entreprise: <?php echo $nom_entreprise ?></p>
                        <p class='card-title'>Numéro de Siret: <?php echo $siret ?></p>
                        <p class='card-title'>adresse de l'entreprise: <?php echo $adresse_entreprise ?></p>
                        <p class='card-title'>email pro: <?php echo $email_pro ?></p>

                        <a href="#" class="btn btn-outline-primary">Modifier le profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>