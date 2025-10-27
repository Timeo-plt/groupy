<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout en prévente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<?php require "../fonctions/login_fonction.php";
$produits = getProduit();
?>
</head>
<body>
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Ajouter en prévente</h5>
        </div>
        <div class="card-body">
            <form action="" method="post" name="ajout_prevente" class="row g-3">
                <div class="col-md-6">
                    <label for="date_limite" class="form-label">Date limite</label>
                    <input type="date" id="date_limite" name="date_limite" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="nombre_min" class="form-label">Nombre minimum de participants</label>
                    <input type="number" id="nombre_min" name="nombre_min" class="form-control" min="1" required>
                </div>

                <div class="col-md-6">
                    <label for="prix_prevente" class="form-label">Prix pour la prévente</label>
                    <div class="input-group">
                        <span class="input-group-text">€</span>
                        <input type="number" id="prix_prevente" name="prix_prevente" class="form-control" step="0.01" min="0" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="statut" class="form-label">Statut</label>
                    <select id="statut" name="statut" class="form-select" required>
                        <option value="en_attente">En attente</option>
                        <option value="valide">Validé</option>
                        <option value="annule">Annulé</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="produit" class="form-label">Choix du produit</label>
                    <select name="produit" id="produit" class="form-select" required>
                        <option value="">-- Choisir un produit --</option>
                        <?php 
                        foreach($produits as $p){
                            echo "<option value='".$p['id_produit']."'>".$p['description']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success" name="ajt_prevente">Ajouter en prévente</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php
if(isset($_POST['ajt_prevente'])){
    array_pop($_POST);
    putPrevente($_POST, $_POST['produit']);
    header("Location: menuVendeur.php");
}
?>
