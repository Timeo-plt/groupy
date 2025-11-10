<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page vendeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <i class="bi bi-sign-turn-slight-right-fill"></i>
</head>


<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PageVendeur</a>
            <div class="d-flex ms-auto">
            <a href="profilVendeur.php" class="btn btn-outline-primary">Profil</a>
            <a href="../login/index.php" class="btn btn-outline-secondary btn-sm">Se déconnecter</a>
            </div>
        </div>
    </nav>
</header>
<body>
    <div class="text-center mt-4">
        <h4>Produits</h4>

<?php  require('../fonctions/login_fonction.php');
$produits = getProduit();
$prevente = getprevente();
$onlyProduits = produitOnly();
?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Image</th>
            <th>Description</th>
            <th>Prix</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($onlyProduits) && is_array($onlyProduits)): ?>
            

            <?php foreach ($onlyProduits as $onlyProduit): ?>
                <tr>
                    <td><?php echo htmlspecialchars($onlyProduit['image']); ?></td>
                    <td><?php echo htmlspecialchars($onlyProduit['description']); ?></td>
                    <td><?php echo htmlspecialchars($onlyProduit['prix']); ?> €</td>
                    <td class="text-end">
                        <div class="btn-group" role="group" aria-label="Actions">
                                <form action="#" method="post" class="d-inline">
                                <input type="hidden" name="id_produit" value="<?php echo htmlspecialchars($onlyProduit['id_produit']); ?>">
                                <input type="hidden" name="description" value="<?php echo htmlspecialchars($onlyProduit['description']); ?>">
                                <input type="hidden" name="image" value="<?php echo htmlspecialchars($onlyProduit['image']); ?>">
                                <input type="hidden" name="prix" value="<?php echo htmlspecialchars($onlyProduit['prix']); ?>">
                                <button type="submit" name="modif_produit" class="btn btn-warning btn-sm">Modifier</button>
                            </form>
                            <form action="#" method="post" class="d-inline ms-2" onsubmit="return confirm('Supprimer ce produit ?');">
                                <input type="hidden" name="id_produit" value="<?php echo htmlspecialchars($onlyProduit['id_produit']); ?>">
                                <input type="hidden" name="description" value="<?php echo htmlspecialchars($onlyProduit['description']); ?>">
                                <input type="hidden" name="image" value="<?php echo htmlspecialchars($onlyProduit['image']); ?>">
                                <input type="hidden" name="prix" value="<?php echo htmlspecialchars($onlyProduit['prix']); ?>">
                                <button type="submit" name="suppr_produit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                                <form action="#" method="post" class="d-inline ms-2" onsubmit="return confirm('Mettre ce produit en prévente ?');">
                                <input type="hidden" name="id_produit" value="<?php echo htmlspecialchars($onlyProduit['id_produit']); ?>">
                                <input type="hidden" name="description" value="<?php echo htmlspecialchars($onlyProduit['description']); ?>">
                                <input type="hidden" name="image" value="<?php echo htmlspecialchars($onlyProduit['image']); ?>">
                                <input type="hidden" name="prix" value="<?php echo htmlspecialchars($onlyProduit['prix']); ?>">
                                <button type="submit" name="put_produit" class="btn btn-primary btn-sm">mettre en prevente</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Aucun produit trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php if(isset($_POST['modif_produit'])):?>
<div class="card mx-auto mt-3" style="max-width:720px;">
    <div class="card-body">
        <h5 class="card-title">Modifier le produit</h5> 
        <form action="#" method="post" class="row g-3">
            <input type="hidden" name="id_produit" value="<?php echo htmlspecialchars($_POST['id_produit']); ?>">
            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($_POST['description']); ?>" required>
            </div>
            <div class="col-12">
                <label for="image" class="form-label">Image</label>
                <input type="text" class="form-control" id="image" name="image" value="<?php echo htmlspecialchars($_POST['image']); ?>" required>
            </div>

            <div class="col-12 col-md-4">
                <label for="prix" class="form-label">Prix</label>
                <div class="input-group">
                    <span class="input-group-text">€</span>
                    <input type="number" step="0.01" min="0" class="form-control" id="prix" name="prix" value="<?php echo htmlspecialchars($_POST['prix']); ?>" required>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                <button type="submit" name="valider_modif" class="btn btn-primary">Valider</button>
                <a href="menuVendeur.php" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
<?php else: ?>
<?php endif; ?>
<?php if (isset($_POST['put_produit'])): ?>
    <div class="card mx-auto mt-3" style="max-width:720px;">
        <div class="card-body">
            <h5 class="card-title">Ajouter en prévente</h5>
            <form action="#" method="post" class="row g-3">
                <input type="hidden" name="id_produit" value="<?php echo htmlspecialchars($_POST['id_produit']); ?>">
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($_POST['description']); ?>" required>
                </div>
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
                <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                    <button type="submit" name="valider_prevente" class="btn btn-primary">Valider</button>
                    <a href="menuVendeur.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
<?php endif; ?>
    <div class="d-flex justify-content-center mt-2">
        <a href="view_prevente.php" class="btn btn-primary">Voir les préventes</a>
        <a href="ajtProduit.php" class="btn btn-success ms-2">Ajouter un produit</a>
    </div></div>
</body>
<footer class="bg-light text-center text-lg-start mt-auto">
    <div class="text-center p-3">
        © <?php echo date("Y"); ?> Groupe Vente. Tous droits réservés.
    </div>
</footer>
</html>
<?php 
if (isset($_POST['valider_modif'])){
    array_pop($_POST);
    update_produit($_POST, $_POST['id_produit']);
}
if (isset($_POST['suppr_produit'])){
    array_pop($_POST);
    deleteProduit($_POST['id_produit']);
}
 if (isset($_POST['valider_prevente'])){
    array_pop($_POST);
    putPrevente($_POST);
 }

?>
