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
			header('location: ../menu/gestionnaire.php');
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
?>