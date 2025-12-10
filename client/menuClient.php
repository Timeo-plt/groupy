<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PageClient</a>
            <div class="d-flex ms-auto gap-2">
                <a href="factures.php" class="btn btn-success">
                    <i class="bi bi-receipt"></i> Mes Factures
                </a>
                <a href="profilClient.php" class="btn btn-outline-primary">Profil</a>
                <a href="../login/index.php" class="btn btn-outline-secondary btn-sm">Se déconnecter</a>
            </div>
        </div>
    </nav>
</header>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Liste des produits en prévente</h2>
        <?php
        if (isset($_SESSION['participation_success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> 
                    <strong>Participation enregistrée !</strong> Votre facture a été générée.
                    <a href="mesFactures.php" class="alert-link">Voir mes factures</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
            unset($_SESSION['participation_success']);
        }
        ?>
        
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
                        <p class='card-text'><s class='text-muted'>Prix normal: ".$produit['prix']." €</s></p>
                        <p class='card-text fw-bold text-success'>Prix de la prevente : ".$produit['prix_prevente']." €</p>
                        <p class='card-text'><span class='badge bg-info'>Statut : ".$produit['statut']."</span></p>
                        
                        <div class='d-grid gap-2'>
                            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalParticiper".$produit['id_prevente']."'>
                                <i class='bi bi-cart-plus'></i> Participer
                            </button>
                            <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#modalSignaler".$produit['id_produit']."'>
                                <i class='bi bi-flag'></i> Signaler
                            </button>
                        </div>
                    </div>
                </div>   
            </div>
            
            <!-- Modal Participer -->
            <div class='modal fade' id='modalParticiper".$produit['id_prevente']."' tabindex='-1'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header bg-primary text-white'>
                            <h5 class='modal-title'><i class='bi bi-cart-check'></i> Confirmer la participation</h5>
                            <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                        </div>
                        <div class='modal-body'>
                            <p><strong>Produit :</strong> ".$produit['description']."</p>
                            <p><strong>Prix prévente :</strong> <span class='text-success fs-5'>".$produit['prix_prevente']." €</span></p>
                            <p><small class='text-muted'>Prix normal : <s>".$produit['prix']." €</s></small></p>
                            <div class='alert alert-info'>
                                <i class='bi bi-info-circle'></i> 
                                Une facture sera automatiquement générée et disponible dans <strong>\"Mes Factures\"</strong>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <form method='POST' action=''>
                                <input type='hidden' name='id_client' value='".$_SESSION['connectedUser']['id_user']."'>
                                <input type='hidden' name='id_prevente' value='".$produit['id_prevente']."'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Annuler</button>
                                <button type='submit' name='participer' class='btn btn-primary'>
                                    <i class='bi bi-check-lg'></i> Confirmer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Signaler -->
            <div class='modal fade' id='modalSignaler".$produit['id_produit']."' tabindex='-1'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header bg-danger text-white'>
                            <h5 class='modal-title'><i class='bi bi-flag'></i> Signaler un problème</h5>
                            <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                        </div>
                        <form method='POST' action=''>
                            <div class='modal-body'>
                                <input type='hidden' name='id_user' value='".$_SESSION['connectedUser']['id_user']."'>
                                <input type='hidden' name='id_produit' value='".$produit['id_produit']."'>
                                <div class='mb-3'>
                                    <label for='date_signalement".$produit['id_produit']."' class='form-label'>Date du signalement</label>
                                    <input type='date' id='date_signalement".$produit['id_produit']."' name='date_signal' class='form-control' required>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Annuler</button>
                                <button type='submit' name='confirmer_signalement' class='btn btn-danger'>
                                    <i class='bi bi-flag-fill'></i> Confirmer le signalement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        ";
    }
}
?>
        </div>
    </div>
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
    $_SESSION['participation_success'] = true;
    exit;
}
if(isset($_POST['confirmer_signalement'])){
    array_pop($_POST);
    signaler($_POST);
    echo "<script>alert('Signalement enregistré avec succès');</script>";
}
?>