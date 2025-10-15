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
if($_SESSION['connectedVendeur']){
    $data=$_SESSION['connectedUser'];
    array_pop($data);
    $nom = $data['nom'];
    $prenom = $data['prenom'];
    $adresse = $data['adresse'];
    $phone = $data['phone'];
    $email = $data['email'];
    $DATA = $_SESSION['connectedVendeur'];
    $nom_entreprise = $DATA['nom_entreprise'];
    $siret = $DATA['siret'];
    $adresse_entreprise = $DATA['adresse_entreprise'];
    $email_pro = $DATA['email_pro'];
}

?>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Profil Vendeur</h4>
                    </div>
                    <div class="card-body text-center">
                        <img src="https://via.placeholder.com/120" class="rounded-circle mb-3" alt="Photo de profil">
                        <h5 class='card-title'>Nom: <?php echo $nom?></h5>
                        <h5 class='card-title'>Prenom: <?php echo $prenom ?></h5>
                        <p class='card-title'>Adresse: <?php echo $adresse ?></p>
                        <p class='card-title'>Numéro de tel: <?php echo $phone ?></p>
                        <p class='card-title'>Adresse mail:<?php echo $email ?></p>
                        <p class='card-title'>Nom entreprise: <?php echo $nom_entreprise ?></p>
                        <p class='card-title'>Numéro de Siret: <?php echo $siret ?></p>
                        <p class='card-title'>adresse de l'entreprise: <?php echo $adresse_entreprise ?></p>
                        <p class='card-title'>email pro: <?php echo $email_pro ?></p>
                        <form action="" method="post">
                            <button class="btn btn-outline-primary" name="modif_vendeur" >Modifier le profil</button>
                            <a href="menuVendeur.php" class="btn btn-outline-secondary btn-sm">Retour</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php if (isset($_POST['modif_vendeur'])): ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark text-center">
                    <h4>Modifier le Profil Vendeur</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <input type="text" class="form-control" name="adresse" value="<?php echo htmlspecialchars($adresse); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Numéro de téléphone</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adresse mail</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nom entreprise</label>
                            <input type="text" class="form-control" name="nom_entreprise" value="<?php echo htmlspecialchars($nom_entreprise); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Numéro de Siret</label>
                            <input type="text" class="form-control" name="siret" value="<?php echo htmlspecialchars($siret); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adresse de l'entreprise</label>
                            <input type="text" class="form-control" name="adresse_entreprise" value="<?php echo htmlspecialchars($adresse_entreprise); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email pro</label>
                            <input type="email" class="form-control" name="email_pro" value="<?php echo htmlspecialchars($email_pro); ?>">
                        </div>
                        <button type="submit" class="btn btn-success" name="save_vendeur">Enregistrer</button>
                        <a href="profilVendeur.php" class="btn btn-secondary ms-2">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
<?php
    if(isset($_POST['save_vendeur'])){
    // array_pop($_POST);
    UpdateVendeur($_POST);
    header ("Location ../vendeur/profilVendeur.php");
}
?>
