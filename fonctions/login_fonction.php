<?php
session_start();
function connectDB(){
	try
	{
		$pdo= new PDO("mysql: host=localhost; dbname=vente_groupe", "tse", "Street1-Grading3-Hydration9");

		return $pdo;
	}
	catch (PDOException $e)
	{
		echo "Erreur de connexion : " . $e->getMessage();
		echo "ça marche pas";
		return null;
	}
}
function deconnectDB($pdo){
	$pdo=null;
}
function addUser($data){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	else{
		$user=getUser($data['email'],$data['motdepasse']);
		if($user)
		{
			echo "Le compte existe déja !";
			deconnectDB($pdo);
			return false;
		}
		else
		{
			try{
				$pwd_non_hash=$data['motdepasse'];
				$data['motdepasse']=password_hash($pwd_non_hash,PASSWORD_DEFAULT);
				$req= " INSERT INTO utilisateur (nom, prenom, adresse, phone, email, motdepasse) VALUES (?,?,?,?,?,?)";
				$stmt=$pdo->prepare($req);
				$params=[
					$data['nom'],
					$data['prenom'],
					$data['adresse'],
					$data['phone'],
					$data['email'],
					$data['motdepasse']
				];

				$result=$stmt->execute($params);
				if(!$result){
					echo $stmt->errorInfo();
					return false;
				}
				else{
					$existUser=getUser($data['email'],$pwd_non_hash);
					$_SESSION['connectedUser']= $existUser;
					deconnectDB($pdo);
					return true;
				}
			}
			catch(PDOException $e){
				echo $e->getMessage();
				deconnectDB($pdo);
				return false;
			}
		}
	}
}

function addClient($data){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	else{
		$user = getUser($data['email'],$data['motdepasse']);
		if($user)
		{
			echo "Le compte existe déja !";
			deconnectDB($pdo);
			return false;
		}
		else
		{
			try{ 
				if(addUser($data) === false){
					echo "probleme ajout user";
					return false;
				}	
				$idClient = $_SESSION['connectedUser']['id_user'];
				if (!$idClient){
					echo "probleme id user";
					return false;
				}
				$req= "INSERT INTO client (id_user) VALUES (?)";
				$stmt=$pdo->prepare($req); 
				$result=$stmt->execute([$idClient]);
		
				if (!$result){
					echo "probleme ajout client";
					return false;
				}
				deconnectDB($pdo);
				return true;
			} 
			catch(PDOException $e){
				echo $e->getMessage();
				deconnectDB($pdo);
				return false;
			}
		}
	}
}

function addVendeur($data){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	else{
		$user = getUser($data['email'], $data['motdepasse']);
		if($user){
			echo "le compte existe déjà";
			deconnectDB($pdo);
			return false;
		}
		else{
			try{
				if(addUser($data) === false){
					echo "problème ajout user";
					return false;
				}
				$idVendeur = $_SESSION['connectedUser']['id_user'];
				if(!$idVendeur){
					echo "problème id user";
					return false;
				}
				$req = "INSERT INTO vendeur (id_user, nom_entreprise, siret, adresse_entreprise, email_pro) VALUES (?,?,?,?,?)";
				$stmt = $pdo->prepare($req);
				$params = [
					$idVendeur,
					$data['nom_entreprise'],
					$data['siret'],
					$data['adresse_entreprise'],
					$data['email_pro']
				];
				$result = $stmt->execute($params);
				if(!$result){
					echo "problème ajout vendeur";
					return false;
				}
				deconnectDB($pdo);
				return true;
			}
			catch(PDOException $e){
				echo $e->getMessage();
				deconnectDB($pdo);
				return false;
			}
		}
	}
}

function getUser($email,$pwd){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	else{
		try{
			$req ="SELECT * FROM utilisateur WHERE email=?";
			$stmt=$pdo->prepare($req);
			$result=$stmt->execute([$email]);
			if(!$result){
				deconnectDB($pdo);
				return false;
			}
			else{
				if($stmt->rowCount()>0){
					$user = $stmt->fetch(PDO::FETCH_ASSOC);
					if(password_verify($pwd,$user['motdepasse']))
					{
						deconnectDB($pdo);
						return $user;
					}
					else{
						echo "mot de passe incorrect";
						deconnectDB($pdo);
						return false;
					}
				}
			}
			
		}
		catch(PDOException $e){
			echo "erreur : ".$e->getMessage();
			deconnectDB($pdo);
			return false;
		}
	}
}

function getRole($iduserConnected){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}

	$idUser = $iduserConnected;
	$stmt = $pdo->prepare("SELECT * FROM vendeur WHERE id_user = :id");
	$stmt->execute(['id' => $idUser]);
	$vendeur = $stmt->fetch(PDO::FETCH_ASSOC);
	if($vendeur){
		$_SESSION['connectedVendeur']= $vendeur;
		return "vendeur";
	}

	$stmt = $pdo->prepare("SELECT * FROM client WHERE id_user = :id");
	$stmt->execute(['id' => $idUser]);
	$client = $stmt->fetch(PDO::FETCH_ASSOC);
	if($client){
		$_SESSION['connectedClient']= $client;
		return "client";
	}

	$stmt = $pdo->prepare("SELECT * FROM gestionnaire WHERE id_user = :id");
	$stmt->execute(['id' => $idUser]);
	$gestionnaire = $stmt->fetch(PDO::FETCH_ASSOC);
	if($gestionnaire){
		$_SESSION['connectedGestionnaire']= $gestionnaire;
		return "gestionnaire";
	}
	
	else{
		deconnectDB($pdo);
		echo "probleme requete";
		return false;
	}

	
}

function connectUser($data){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
		
		$user = getUser($data['email'],$data['motdepasse']);
		if(!$user){
			echo "user doesnt exist";
			return false;
		}
		else{

			$_SESSION['connectedUser']=$user;
			$idUser= $user['id_user'];
		}
		$role = getRole ($idUser);

		if($role == "vendeur"){
			deconnectDB($pdo);
			header('location: ../vendeur/menuVendeur.php');
		}
		else if($role == "client"){
			deconnectDB($pdo);
			header('location: ../client/menuClient.php');
		}
		else if($role == "gestionnaire"){
			deconnectDB($pdo);
			header('location: ../gestionnaire/menuGestion.php');
		}
		else{
			echo "problème de rôle";
			return false;
		}
}
	
	function disconnectUser(){
		session_unset();
		session_destroy();
		header('Location:register.php');
		
} 

function UpdateUser($data){
		$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	$data['id_user']=$_SESSION['connectedUser']['id_user'];
	$data['motdepasse']=$_SESSION['connectedUser']['motdepasse'];
	$req = "UPDATE utilisateur SET nom =?, prenom=?, adresse=?, phone=?,email=?,motdepasse=? WHERE id_user=?";
	$stmt = $pdo->prepare($req);
	$params = [
		$data['nom'],		
		$data['prenom'],
		$data['adresse'],
		$data['phone'],
		$data['email'],
		$data['motdepasse'],
		$data['id_user'],
	];
	$result = $stmt->execute($params);
	$_SESSION['connectedUser']['nom'] = $data['nom'];
	$_SESSION['connectedUser']['prenom'] = $data['prenom'];
	$_SESSION['connectedUser']['adresse'] = $data['adresse'];
	$_SESSION['connectedUser']['phone'] = $data['phone'];
	$_SESSION['connectedUser']['email'] = $data['email'];
	$_SESSION['connectedUser']['motdepasse'] = $data['motdepasse'];
	$_SESSION['connectedUser']['id_user'] = $data['id_user'];
}

function ajout_categorie($data) {
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}

	$idUser = $_SESSION['connectedUser']['id_user'];
	$req = "SELECT * FROM gestionnaire WHERE id_user = ?";
	$stmt = $pdo->prepare($req);
	$stmt->execute([$idUser]);
	$gestionnaire = $stmt->fetch(PDO::FETCH_ASSOC);
	if(!$gestionnaire){
		deconnectDB($pdo);
		return false;
	}
	$idGestion = $gestionnaire['id_user'];

	$req = "INSERT INTO categorie (id_gestionnaire, lib) VALUES (?, ?)";
	$stmt = $pdo->prepare($req);
	$params = [
		$idGestion,
		$data['lib'],
	];
	$result = $stmt->execute($params);
	if($result){
		deconnectDB($pdo);
		return true;
	}
}

function getCategorie(){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT * FROM categorie WHERE lib IS NOT NULL"; 
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	else{
		$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
		deconnectDB($pdo);
		return $categories;

	}


}
function ajout_produit($data){
	$pdo = connectDB();
	if(!$pdo){
		return false;
	}
	$iduser = $_SESSION['connectedUser']['id_user'];

	$req = "INSERT INTO produit (id_categorie, description, prix, image, id_vendeur) VALUES (?,?,?,?,?)";
	$stmt = $pdo->prepare($req);
	$params = [
		$data['libelle'],
		$data['description'],
		$data['prix'],
		$data['image'],
		$iduser
	];
	$result = $stmt->execute($params);
	if($result){
		deconnectDB($pdo);
		header('Location: menuVendeur.php');
		return true;
	}
}

function getProduit(){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT * FROM produit"; 
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	else{
		$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
		deconnectDB($pdo);
		return $produits;

	}
}

function produitOnly() {
		$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT produit.id_produit, id_categorie, produit.description, prix, image, id_vendeur FROM produit LEFT JOIN prevente  ON prevente.id_produit = produit.id_produit WHERE prevente.id_produit IS NULL;"; 
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	else{
		$onlyProduits = $stmt->fetchAll(PDO::FETCH_ASSOC);
		deconnectDB($pdo);
		return $onlyProduits;

	}
}
function UpdateVendeur($data){
	$pdo=connectDB();	
	if(!$pdo){
		return false;
	}
	$data['id_user']=$_SESSION['connectedUser']['id_user'];
	$data['motdepasse']=$_SESSION['connectedUser']['motdepasse'];
	$req = "UPDATE utilisateur SET nom =?, prenom=?, adresse=?, phone=?,email=?,motdepasse=? WHERE id_user=?";
	$stmt = $pdo->prepare($req);
	$params = [
		$data['nom'],		
		$data['prenom'],
		$data['adresse'],
		$data['phone'],
		$data['email'],
		$data['motdepasse'],
		$data['id_user'],
	];
	$result = $stmt->execute($params);
	$_SESSION['connectedUser']['nom'] = $data['nom'];
	$_SESSION['connectedUser']['prenom'] = $data['prenom'];
	$_SESSION['connectedUser']['adresse'] = $data['adresse'];
	$_SESSION['connectedUser']['phone'] = $data['phone'];
	$_SESSION['connectedUser']['email'] = $data['email'];
	$_SESSION['connectedUser']['motdepasse'] = $data['motdepasse'];
	$_SESSION['connectedUser']['id_user'] = $data['id_user'];
	
	if($result){
		$data['id_user']=$_SESSION['connectedVendeur']['id_user'];
		$req = "UPDATE vendeur SET nom_entreprise =?, siret=?, adresse_entreprise=?, email_pro=? WHERE id_user=?";
		$stmt = $pdo->prepare($req);
		$params = [
			$data['nom_entreprise'],		
			$data['siret'],
			$data['adresse_entreprise'],
			$data['email_pro'],
			$data['id_user'],
		];
	$result = $stmt->execute($params);
	$_SESSION['connectedVendeur']['nom_entreprise'] = $data['nom_entreprise'];
	$_SESSION['connectedVendeur']['siret'] = $data['siret'];
	$_SESSION['connectedVendeur']['adresse_entreprise'] = $data['adresse_entreprise'];
	$_SESSION['connectedVendeur']['email_pro'] = $data['email_pro'];
	$_SESSION['connectedVendeur']['id_user'] = $data['id_user'];
	}

		
}

function update_produit($data, $idproduit){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
		$req = "UPDATE produit SET description =?, prix=?, image=? WHERE id_produit=$idproduit";
	$stmt = $pdo->prepare($req);
	$params = [
		$data['description'],
		$data['prix'],
		$data['image']
	];
	$result = $stmt->execute($params);
	if($result){
		deconnectDB($pdo);
		return true;
	}
	$produit['description'] = $data['description'];
	$produit['prix'] = $data['prix'];
	$produit['image'] = $data['image'];
}

function deleteProduit($idproduit){
	$pdo=connectDB();
	if(!$pdo){
		deconnectDB($pdo);
		return false;
	}
	$req = "DELETE FROM produit WHERE id_produit = $idproduit";
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if($result){
		deconnectDB($pdo);
		return true;
	}
}

function getUtilisateur(){
	$pdo = connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT * FROM utilisateur";
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	else{
		$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		deconnectDB($pdo);
		return $utilisateurs;
	}
}

function putPrevente($data){
	
	$pdo =connectDB();
	if(!$pdo){
		return false;
	}

	$req = "INSERT INTO prevente (date_limite, nombre_min, statut, prix_prevente,id_produit,description) VALUES (?,?,?,?,?,?)";
	$stmt = $pdo->prepare($req);
	$params = [
		$data['date_limite'],
		$data['nombre_min'],
		$data['statut'],
		$data['prix_prevente'],
		$data['id_produit'],
		$data['description'],
	];
	$result = $stmt->execute($params);
	if($result){
		deconnectDB($pdo);
		return true;
	}
	$prevente = $result;
}

function getprevente()  {
	$pdo = connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT * FROM prevente";
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	else{
		$preventes = $stmt->fetchAll(PDO::FETCH_ASSOC);
		deconnectDB($pdo);
		return $preventes;
	}
}

function uploadPic(array $file): string|false {
	$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
	$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
	$maxSize = 500000;
	$uploadDir = 'uploads/';

	if (!is_dir($uploadDir)) {
		mkdir($uploadDir, 0755, true);
	}

	if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
		echo "Aucun fichier valide n'a été téléchargé.";
		return false;
	}

	$imageInfo = getimagesize($file['tmp_name']);
	if ($imageInfo === false) {
		echo "Le fichier n'est pas une image valide.";
		return false;
	}

	$mimeType = $imageInfo['mime'];
	$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

	if (!in_array($mimeType, $allowedTypes) || !in_array($extension, $allowedExtensions)) {
		echo "Type de fichier non autorisé. Formats acceptés : JPG, JPEG, PNG, GIF.";
		return false;
	}

	if ($file['size'] > $maxSize) {
		echo "Fichier trop volumineux. Taille maximale : 500 Ko.";
		return false;
	}

	$filename = uniqid('img_', true) . '.' . $extension;
	$targetFile = $uploadDir . $filename;

	if (move_uploaded_file($file['tmp_name'], $targetFile)) {
		return $targetFile;
	} else {
		echo "Erreur lors du téléchargement de l'image.";
		return false;
	}
}
function preventClient(){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT  produit.*, prevente.* FROM    produit AS produit JOIN    prevente AS prevente ON    prevente.id_produit = produit.id_produit";
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	else{
		$preventeclient = $stmt->fetchAll(PDO::FETCH_ASSOC);
		deconnectDB($pdo);
		return $preventeclient;
	}
}

?>	