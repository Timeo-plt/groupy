<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>
    <header class="bg-primary text-white text-center py-4 mb-4">
        <h1>Page de connexion</h1>
    </header>
    <div class="d-flex justify-content-center">
        <form action="#" method="post" name="connexion" class="w-50">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="entrez votre adresse mail">
            </div>
            <div class="mb-3">
                <label for="motdepasse" class="form-label">Mot de passe:</label>
                <input type="password" name="motdepasse" id="motdepasse" class="form-control" placeholder="entrez votre mot de passe">
            </div>
            <button type="submit" class="btn btn-primary w-100">Connexion</button>
        </form>
    </div>
</body>
<footer class="bg-light text-center py-3 mt-4">
    <a href="register.php" class="btn btn-secondary">Inscription</a>
</footer>
</html>
<?php
require_once('../fonctions/login_fonction.php');
if(isset($_POST['submit']))
{
  connectUser($_POST);
}
?>