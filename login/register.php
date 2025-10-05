<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<header class="bg-primary text-white text-center py-4 mb-4">
  <h1 class="display-4">Page d'inscription</h1>
</header>
<body>
<div class="container d-flex flex-column align-items-center">
  <form action="" method="post" name="client" class="mb-2">
    <button id="client" type="submit" name="client" class="btn btn-primary">Client</button>
  </form>
  <form action="" method="post" name="vendeur">
    <button id="vendeur" type="submit" name="vendeur" class="btn btn-secondary">Vendeur</button>
  </form>
</div>

<?php
if(!isset($_POST ['client']) && !isset($_POST ['vendeur']))
{
  echo"";
}
else if (isset($_POST['client']))
{
  echo '<form method="post" action="#" class="d-flex flex-column align-items-center">
  <div class="form-row align-content-center w-100">
    <div class="form-group col-md-6 mx-auto">
      <label for="nom">Nom: </label>
      <input type="text" class="form-control" id="nom" name="nom" placeholder="Veuillez entrer votre nom">
    </div>
    <div class="form-group col-md-6 mx-auto">
      <label for="prenom">Prenom: </label>
      <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Veuillez entrer votre prénom">
    </div>
  </div>
  <div class="form-group col-md-6 mx-auto">
    <label for="adresse">Adresse: </label>
    <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Veuillez entrer votre adresse">
  </div>
  <div class="form-group col-md-6 mx-auto">
    <label for="phone">Téléphone</label>
    <input type="number" class="form-control" id="phone" name="phone" placeholder="Veuillez entrer votre téléphone">
  </div>
  <div class="form-row w-100">
    <div class="form-group col-md-6 mx-auto">
      <label for="email">Email: </label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Veuillez entrer votre email">
    </div>
    <div class="form-group col-md-6 mx-auto">
      <label for="motdepasse">Mot de passe: </label>
      <input type="password" class="form-control" id="motdepasse" name="motdepasse" placeholder="Veuillez entrer votre mot de passe">
    </div>
  </div>
  <button type="submit" name="submit_client" class="btn btn-success mt-3">Valider</button>
</form>';
}

else if (isset($_POST['vendeur']))
{
  echo '<form method="post" action="#" class="d-flex flex-column align-items-center">
    <div class="form-row w-100">
      <div class="form-group col-md-6 mx-auto">
        <label for="nom">Nom: </label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Veuillez entrer votre nom">
      </div>
      <div class="form-group col-md-6 mx-auto">
        <label for="prenom">Prenom: </label>
        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Veuillez entrer votre prénom">
      </div>
    </div>
    <div class="form-group col-md-6 mx-auto">
      <label for="adresse">Adresse: </label>
      <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Veuillez entrer votre adresse">
    </div>
    <div class="form-group col-md-6 mx-auto">
      <label for="phone">Téléphone</label>
      <input type="number" class="form-control" id="phone" name="phone" placeholder="Veuillez entrer votre téléphone">
    </div>
    <div class="form-row w-100">
      <div class="form-group col-md-6 mx-auto">
        <label for="email">Email: </label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Veuillez entrer votre email">
      </div>
      <div class="form-group col-md-6 mx-auto">
        <label for="motdepasse">Mot de passe: </label>
        <input type="password" class="form-control" id="motdepasse" name="motdepasse" placeholder="Veuillez entrer votre mot de passe">
      </div>
    </div>
    <div class="form-group col-md-6 mx-auto">
      <label for="nom_entreprise">Nom entreprise: </label>
      <input type="text" class="form-control" id="nom_entreprise" name="nom_entreprise" placeholder="Veuillez entrer le nom de votre entreprise">
    </div>
    <div class="form-group col-md-6 mx-auto">
      <label for="siret">Siret: </label>
      <input type="number" class="form-control" id="siret" name="siret" placeholder="Veuillez entrer votre numéro de siret">
    </div>
    <div class="form-group col-md-6 mx-auto">
      <label for="adresse_entreprise">Adresse entreprise: </label>
      <input type="text" class="form-control" id="adresse_entreprise" name="adresse_entreprise" placeholder="Adresse de votre entreprise">
    </div>
    <div class="form-group col-md-6 mx-auto">
      <label for="email_pro">Email pro: </label>
      <input type="email" class="form-control" id="email_pro" name="email_pro" placeholder="Veuillez entrer votre email professionnel">
    </div>
    <button type="submit" name="submit_vendeur" class="btn btn-success mt-3">Valider</button>
  </form>';
}
?>
</body>
<footer class="bg-dark text-white text-center py-4 mt-5">
  <div class="container">
    <h5 class="mb-2">Footer</h5>
    <p class="mb-0">&copy; <?php echo date("Y"); ?> Groupe Vente. Tous droits réservés.</p>
    <a href="index.php" class="btn btn-outline-light">Retour</a>
  </div>
</footer>
</html>


<?php
require '../fonctions/login_fonction.php';
if (isset($_POST['submit_client'])){
  array_pop ($_POST);
  addClient($_POST);
}
else if (isset($_POST['submit_vendeur'])){
  array_pop ($_POST);
  addVendeur($_POST);
}

?>
