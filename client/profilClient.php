<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<?php
require('../fonctions/login_fonction.php');
if($_SESSION['connectedUser']){
    $data=$_SESSION['connectedUser'];
    array_pop($data);
    $nom = $data['nom'];
    $prenom = $data['prenom'];
    $adresse = $data['adresse'];
    $phone = $data['phone'];
    $email = $data['email'];
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
                        <form action="" method="post" name="modif_client">
                        <button class="btn btn-outline-primary" name="modif_client">Modifier le profil</button>
                        </form>
                        <br>
                        <a href="menuClient.php"><button class="btn btn-outline-primary">Retour au menu</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php if(isset($_POST["modif_client"])) : ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Modifier le Profil</h4>
                </div>
                <div class="card-body">
                    <form action="#" method="post" name="save_client">
                        <div class="mb-3 text-center">
                            <img src="https://via.placeholder.com/120" class="rounded-circle mb-3" alt="Photo de profil">
                        </div>
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo htmlspecialchars($adresse); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Numéro de téléphone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="d-grid">
                             <button type="submit" name="save_client" class="btn btn-primary">Enregistrer les modifications</button>  
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?> 
<?php
if(isset($_POST['save_client'])){
    // array_pop($_POST);
    UpdateUser($_POST);
    header ("location ../client/profilClient.php");
}
?>

