<?php
// ============================================================================
// FICHIER : client/factures.php
// Page pour consulter et télécharger les factures
// ============================================================================
require('../fonctions/login_fonction.php');

// Vérifier que l'utilisateur est connecté et est un client
if (!isset($_SESSION['connectedUser']) || !isset($_SESSION['connectedClient'])) {
    header('Location: ../login/index.php');
    exit;
}

$idClient = $_SESSION['connectedUser']['id_user'];
$factures = getClientInvoices($idClient);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Factures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .invoice-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .invoice-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .badge-economy {
            background-color: #10b981;
        }
    </style>
</head>
<body class="bg-light">
    
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="menuClient.php">
                <i class="bi bi-receipt"></i> Mes Factures
            </a>
            <div class="d-flex ms-auto gap-2">
                <a href="menuClient.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
                <a href="profilClient.php" class="btn btn-outline-primary">
                    <i class="bi bi-person"></i> Profil
                </a>
                <a href="../login/index.php" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </div>
        </div>
    </nav>
</header>

<div class="container my-5">
    <div class="row mb-4">
        <div class="col">
            <h2 class="mb-3">
                <i class="bi bi-file-earmark-text text-primary"></i> 
                Mes Factures de Prévente
            </h2>
            <p class="text-muted">Consultez et téléchargez vos factures de participation aux préventes.</p>
        </div>
    </div>

    <?php if ($factures && count($factures) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($factures as $facture): 
                $economie = $facture['prix_normal'] - $facture['prix_prevente'];
            ?>
                <div class="col">
                    <div class="card invoice-card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-receipt-cutoff"></i> 
                                Facture du <?php echo date('d/m/Y', strtotime($facture['date_facture'])); ?>
                            </h6>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <?php echo htmlspecialchars($facture['prevente_desc']); ?>
                            </h5>
                            
                            <div class="mb-3">
                                <p class="mb-2">
                                    <strong>Prix prévente :</strong> 
                                    <span class="text-success fs-5">
                                        <?php echo number_format($facture['prix_prevente'], 2, ',', ' '); ?> €
                                    </span>
                                </p>
                                <p class="mb-2">
                                    <small class="text-muted">
                                        Prix normal : 
                                        <s><?php echo number_format($facture['prix_normal'], 2, ',', ' '); ?> €</s>
                                    </small>
                                </p>
                                <span class="badge badge-economy">
                                    <i class="bi bi-piggy-bank"></i> 
                                    Économie : <?php echo number_format($economie, 2, ',', ' '); ?> €
                                </span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="bi bi-calendar-event"></i> 
                                    Participation : <?php echo date('d/m/Y à H:i', strtotime($facture['date_participation'])); ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="d-grid gap-2">
                                <a href="../factures/<?php echo urlencode($facture['pdf_facture']); ?>" 
                                   class="btn btn-primary" 
                                   target="_blank">
                                    <i class="bi bi-eye"></i> Voir la facture PDF
                                </a>
                                <a href="../factures/<?php echo urlencode($facture['pdf_facture']); ?>" 
                                   class="btn btn-outline-primary"
                                   download>
                                    <i class="bi bi-download"></i> Télécharger PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
            <h4>Aucune facture disponible</h4>
            <p class="mb-0">Vous n'avez pas encore participé à des préventes.</p>
            <a href="menuClient.php" class="btn btn-primary mt-3">
                <i class="bi bi-cart-plus"></i> Parcourir les préventes
            </a>
        </div>
    <?php endif; ?>
</div>

<footer class="bg-white text-center text-lg-start mt-5 py-3 shadow-sm">
    <div class="text-center">
        © <?php echo date("Y"); ?> Groupe Vente. Tous droits réservés.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>