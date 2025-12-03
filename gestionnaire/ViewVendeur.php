<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>View Vendeur</title>
</head>
<header>
    <div class="bg-dark text-white text-center py-2 mb-3">
      <h5 class="mb-0 d-inline-block">Liste des Vendeurs</h5>
    <div class="float-end">
        <a href="menuGestion.php" class="btn btn-outline-light btn-sm me-2" role="button" aria-label="Menu">Menu</a>
        <a href="ajtCategorie.php" class="btn btn-outline-light btn-sm me-2" role="button" aria-label="Ajouter Catégorie">Ajouter Catégorie</a>
        <a href="ViewClient.php" class="btn btn-outline-light btn-sm" role="button" aria-label="Liste clients">Liste clients</a>
    </div>

      
    </div>
</header>
<body>
<?php require "../fonctions/login_fonction.php";
$vendeurs = getvendeur();
?>
<table class="table table-striped table-hover table-bordered table-sm align-middle">
    <thead class="table-dark">
        <tr class="text-center">
            <th class="px-3">Nom</th>
            <th class="px-3">Prénom</th>
            <th class="px-3">email</th>
            <th class="px-3">email pro</th>
            <th class="px-3">Siret</th>
            <th class="px-3">ID</th>
            <th class="px-3">Actions</th>
        </tr>
    <tbody>
        <tr class="text-center">
            <?php foreach($vendeurs as $vendeur): ?>
            <td class="px-2 text-center"><?php echo $vendeur['nom']; ?></td>
            <td class="px-2 text-center"><?php echo $vendeur['prenom']; ?></td>
            <td class="px-2 text-center"><?php echo $vendeur['email']; ?></td>
            <td class="px-2 text-center"><?php echo $vendeur['email_pro']; ?></td>
            <td class="px-2 text-center"><?php echo $vendeur['siret']; ?></td>
            <td class="px-2 text-center"><?php echo $vendeur['id_user']; ?></td>
            <td class="px-2 text-center">
                <form action="" method="post" class="d-inline">
                    <?php if(isblocked($vendeur['id_user'])== 'true'): ?>
                    <input type="hidden" name="id_vendeur" value="<?php echo $vendeur['id_user']; ?>">
                    <button type="submit" name="deblocage_vendeur" class="btn btn-success btn-sm">Débloquer</button>
                    <?php else: ?>
                    <input type="hidden" name="id_vendeur" value="<?php echo $vendeur['id_user']; ?>">
                    <button type="submit" name="blocage_vendeur" class="btn btn-danger btn-sm">Bloquer</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
            <?php endforeach; ?>
    </tbody>
</table>
<?php if(isset($_POST['blocage_vendeur'])){
echo"                
    <form method='POST' action='' class='card p-3 bg-light shadow-sm' style='max-width:600px; margin:auto;'>
    <input type='hidden' name='id_gestionnaire' value='".$_SESSION['connectedUser']['id_user']."'>
    <input type='hidden' name='id_vendeur' value='".$_POST['id_vendeur']."'>
    <div class='mb-3'>
        <label for='date_blocage' class='form-label'>Date du blocage</label>
        <input type='date' id='date_blocage' name='date_blocage' class='form-control' >
    </div>
    <div class='d-flex justify-content-end gap-2'>
        <button type='submit' name='confirmer_blocage' class='btn btn-danger btn-sm'>Confirmer</button>
        <button type='submit' name='annuler_blocage' class='btn btn-secondary'>Annuler</button>
    </div>
    </form>";
}
?>
<?php if(isset($_POST['deblocage_vendeur'])){
echo"                
    <form method='POST' action='' class='card p-3 bg-light shadow-sm' style='max-width:600px; margin:auto;'>
    <input type='hidden' name='id_gestionnaire' value='".$_SESSION['connectedUser']['id_user']."'>
    <input type='hidden' name='id_vendeur' value='".$_POST['id_vendeur']."'>
    <div class='mb-3'>
        <label for='date_deblocage' class='form-label'>Date du déblocage</label>
        <input type='date' id='date_deblocage' name='date_deblocage' class='form-control' >
    </div>
    <div class='d-flex justify-content-end gap-2'>
        <button type='submit' name='confirmer_deblocage' class='btn btn-danger btn-sm'>Confirmer</button>
        <button type='submit' name='annuler_deblocage' class='btn btn-secondary'>Annuler</button>
    </div>
    </form>";
}
?>

<?php 
if(isset($_POST['confirmer_blocage'])){
    array_pop($_POST);
    bloquerVendeur($_POST);
    ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-width:600px; margin:auto;">
        Vendeur bloqué !
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
}
if(isset($_POST['confirmer_deblocage'])){
    array_pop($_POST);
    deblocage($_POST);
    ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-width:600px; margin:auto;">
        Vendeur débloqué !
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
}
?>

</body>
</html>