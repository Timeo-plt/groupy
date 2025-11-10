<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<?php
require_once('../fonctions/login_fonction.php');
?>
</head>
<body>

    <div class="container mt-5">
        <form action="" method="post" name="form_ajout" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
            <label for="libelle" class="form-label">Libellé</label>
            <select class="form-control" name="libelle" id="libelle">
            <option value="" disabled selected>-- Sélectionner une catégorie --</option>
            <?php
                if($categorie = getCategorie()){
                    foreach($categorie as $cat){
                        echo "<option value='".$cat['id_categorie']."'>".$cat['lib']."</option>";
                    }
                }
            ?>
            </select>   
            </div>
            <div class="col-md-6">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Description du produit">
            </div>
            <div class="col-md-6">
            <label for="prix" class="form-label">Prix</label>
            <input type="text" class="form-control" id="prix" name="prix" placeholder="Prix du produit">
            </div>
            <div class="col-md-6">
            <label for="image" class="form-label">Image</label>
            <input type="text" class="form-control" id="image" name="image">
            </div>
            <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary btn-sm">Ajouter</button>
            <button type="reset" class="btn btn-secondary btn-sm">Annuler</button>
            </div>
        </form>
        <br>
            <a href="menuVendeur.php" class="btn btn-outline-secondary btn-sm">Retour</a>
    </div>
</body>
</html>
<?php
// if(isset($_FILES['image'])){
//     $files = $_FILES['image'];
//     uploadPic($files);
// }
if(isset($_POST['submit'])){
    array_pop($_POST);
    ajout_produit($_POST);
}
?>