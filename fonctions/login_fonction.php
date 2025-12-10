<?php
session_start();
function connectDB(){
	try
	{
		$pdo= new PDO("mysql: host=localhost; dbname=vente_groupy", "tse", "Street1-Grading3-Hydration9");

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

function getclient(){
	$pdo = connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT * FROM utilisateur JOIN client ON utilisateur.id_user = client.id_user";
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	else{
		$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
		deconnectDB($pdo);
		return $clients;

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

function getvendeur(){
	$pdo = connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT * FROM utilisateur JOIN vendeur ON utilisateur.id_user = vendeur.id_user"; 
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	else{
		$vendeurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		deconnectDB($pdo);
		return $vendeurs;

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

function participation($data) {
    $pdo = connectDB();
    if (!$pdo) {
        return false;
    }
    
    try {
        $req = "INSERT INTO participation (id_client, id_prevente) VALUES (?,?)";
        $stmt = $pdo->prepare($req);
        $params = [
            $data['id_client'],
            $data['id_prevente'],
        ];
        $result = $stmt->execute($params);
        
        if ($result) {
            $idParticipation = $pdo->lastInsertId();
            deconnectDB($pdo);
            
            $invoiceResult = generateAndSaveInvoice(
                $data['id_client'], 
                $data['id_prevente'],
                $idParticipation
            );
            
            return true;
        }
        
        deconnectDB($pdo);
        return false;
        
    } catch (PDOException $e) {
        deconnectDB($pdo);
        return false;
    }
}
function signaler ($data){
	$pdo = connectDB();
	if(!$pdo){
		return false;
	}
	$req = "INSERT INTO signaler (id_user, id_produit, date_signal) VALUES (?,?,?)";
	$stmt = $pdo->prepare($req);
	$params = [
		$data['id_user'],
		$data['id_produit'],
		$data['date_signal'],
	];
	$result = $stmt->execute($params);
	if($result){
		deconnectDB($pdo);
		return true;
	}
	deconnectDB($pdo); 
	return false;
}  

function bloquerVendeur($data) {
	$pdo = connectDB();
	if(!$pdo){
		return false;
	}
	$req = "INSERT INTO bloquer (id_gestionnaire, id_vendeur, date_blocage) VALUES (?,?,?)";
	$stmt = $pdo->prepare($req);
	$params = [
		$data['id_gestionnaire'],
		$data['id_vendeur'],
		$data['date_blocage'],
	];
	$result = $stmt->execute($params);
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	$REQ = "DELETE FROM debloquer WHERE id_vendeur = ?";
	$stmt = $pdo->prepare($REQ);
	$params = [
		$data['id_vendeur'],
	];
	$result = $stmt->execute($params);
	if (!$result){
		deconnectDB($pdo);
		return false;
	}
	deconnectDB($pdo);
	return $result;
}

function isblocked($idVendeur){
	$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT * from bloquer where id_vendeur = ?";
	$stmt = $pdo->prepare($req);
	$stmt->execute([$idVendeur]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if($result){
		deconnectDB($pdo);
		return true;
	}
	else{
		deconnectDB($pdo);
		return false;
	}
	
	
}

function signalBlocage(){
		$pdo=connectDB();
	if(!$pdo){
		return false;
	}
	$req = "SELECT DISTINCT t.id_vendeur
FROM (
    SELECT 
        p.id_produit,
        p.id_vendeur
    FROM produit p
    JOIN signaler s 
        ON p.id_produit = s.id_produit
    GROUP BY p.id_produit, p.id_vendeur
    HAVING COUNT(DISTINCT s.id_user) > 0.5 * (SELECT COUNT(*) FROM client)
) AS t
LEFT JOIN bloquer b 
    ON b.id_vendeur = t.id_vendeur
LEFT JOIN debloquer d
    ON d.id_vendeur = t.id_vendeur
WHERE b.id_vendeur IS NULL
  AND d.id_vendeur IS NULL
";
	$stmt = $pdo->prepare($req);
	$result = $stmt->execute();
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	else{
		$vendeursAbloquer = $stmt->fetchAll(PDO::FETCH_ASSOC);
		deconnectDB($pdo);
		return $vendeursAbloquer;

	}
}

function deblocage($data){
	$pdo = connectDB();
	if(!$pdo){
		return false;
	}
	$req = "DELETE FROM bloquer WHERE id_vendeur = ?";
	$stmt = $pdo->prepare($req);
	$params = [
		$data['id_vendeur'],
	];
	$result = $stmt->execute($params);
	if(!$result){
		deconnectDB($pdo);
		return false;
	}
	$REQ = "INSERT INTO debloquer (id_gestionnaire, id_vendeur, date_deblocage) VALUES (?,?,?)";
	$stmt = $pdo->prepare($REQ);
	$params = [
		$data['id_gestionnaire'],
		$data['id_vendeur'],
		$data['date_deblocage'],
	];
	$result = $stmt->execute($params);
	deconnectDB($pdo);
	return $result;
}

function uploadPic($file) {
    // Vérifier que le fichier est valide
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return false;
    }
    
    // Créer le dossier s'il n'existe pas
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Vérifier que c'est bien une image
    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return false;
    }
    
    // Valider l'extension et le type MIME
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $mimeType = $imageInfo['mime'];
    
    if (!in_array($extension, $allowedExtensions) || !in_array($mimeType, $allowedMimeTypes)) {
        return false;
    }
    
    // Vérifier la taille (5MB max)
    if ($file['size'] > 5000000) {
        return false;
    }
    
    // Générer un nom unique et déplacer le fichier
    $uniqueName = uniqid('img_', true) . '.' . $extension;
    $targetFile = $uploadDir . $uniqueName;
    
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return $targetFile;
    }
    
    return false;
}
function generateInvoiceNumber() {
    $year = date('Y');
    $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    return "FACT-{$year}-{$random}";
}
//  * Génère et sauvegarde une facture lors de la participation à une prévente
//  * Cette fonction est appelée automatiquement après l'insertion dans la table participation

function generateAndSaveInvoice($idClient, $idPrevente, $idParticipation) {
    $pdo = connectDB();
    if (!$pdo) {
        return false;
    }
    
    try {
        // Récupérer les informations du client
        $reqClient = "SELECT u.nom, u.prenom, u.email, u.adresse, u.phone 
                      FROM utilisateur u 
                      JOIN client c ON u.id_user = c.id_user 
                      WHERE c.id_user = ?";
        $stmtClient = $pdo->prepare($reqClient);
        $stmtClient->execute([$idClient]);
        $client = $stmtClient->fetch(PDO::FETCH_ASSOC);
        
        if (!$client) {
            deconnectDB($pdo);
            return false;
        }
        
        // Récupérer les informations de la prévente et du produit
        $reqPrevente = "SELECT pr.*, p.description as produit_desc, p.image, p.prix as prix_normal,
                        v.nom_entreprise, v.siret, v.adresse_entreprise, v.email_pro
                        FROM prevente pr
                        JOIN produit p ON pr.id_produit = p.id_produit
                        JOIN vendeur v ON p.id_vendeur = v.id_user
                        WHERE pr.id_prevente = ?";
        $stmtPrevente = $pdo->prepare($reqPrevente);
        $stmtPrevente->execute([$idPrevente]);
        $prevente = $stmtPrevente->fetch(PDO::FETCH_ASSOC);
        
        if (!$prevente) {
            deconnectDB($pdo);
            return false;
        }
        
        // Générer le numéro de facture
        $invoiceNumber = generateInvoiceNumber();
        $invoiceDate = date('d/m/Y');
        
        // Calculs
        $quantity = 1;
        $unitPrice = floatval($prevente['prix_prevente']);
        $totalHT = $quantity * $unitPrice;
        $tva = $totalHT * 0.20;
        $totalTTC = $totalHT + $tva;
        
        // Générer le HTML de la facture
        $html = generateInvoiceHTML($client, $prevente, $invoiceNumber, $invoiceDate, $quantity, $unitPrice, $totalHT, $tva, $totalTTC);
        
        // Créer le dossier factures s'il n'existe pas
        $facturesDir = __DIR__ . '/../factures/';
        if (!file_exists($facturesDir)) {
            mkdir($facturesDir, 0755, true);
        }
        
        // Sauvegarder la facture
        $filename = 'Facture_' . $invoiceNumber . '.html';
        $filepath = $facturesDir . $filename;
        file_put_contents($filepath, $html);
        
        // Enregistrer la facture dans la base de données
        $reqFacture = "INSERT INTO facture (date_facture, pdf_facture) VALUES (?, ?)";
        $stmtFacture = $pdo->prepare($reqFacture);
        $stmtFacture->execute([date('Y-m-d'), $filename]);
        $idFacture = $pdo->lastInsertId();
        
        // Mettre à jour la participation avec l'id de la facture
        $reqUpdate = "UPDATE participation SET id_facture = ? WHERE id_particiption = ?";
        $stmtUpdate = $pdo->prepare($reqUpdate);
        $stmtUpdate->execute([$idFacture, $idParticipation]);
        
        deconnectDB($pdo);
        
        // Retourner le chemin de la facture pour téléchargement
        return [
            'success' => true,
            'invoice_number' => $invoiceNumber,
            'filepath' => $filepath,
            'filename' => $filename
        ];
        
    } catch (PDOException $e) {
        echo "Erreur génération facture : " . $e->getMessage();
        deconnectDB($pdo);
        return false;
    }
}
// * Génère le HTML de la facture
//  */
function generateInvoiceHTML($client, $prevente, $invoiceNumber, $invoiceDate, $quantity, $unitPrice, $totalHT, $tva, $totalTTC) {
    
    $html = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture ' . htmlspecialchars($invoiceNumber) . '</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            color: #333;
            background: white;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2563eb;
        }
        .company-info { font-size: 14px; }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .invoice-info { text-align: right; }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
        }
        .buyer-info {
            margin: 30px 0;
            padding: 20px;
            background: #f3f4f6;
            border-radius: 8px;
        }
        .buyer-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        th {
            background: #2563eb;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .totals {
            margin-top: 30px;
            float: right;
            width: 350px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .total-row.final {
            background: #2563eb;
            color: white;
            font-weight: bold;
            font-size: 20px;
            margin-top: 10px;
            border-radius: 4px;
            border: none;
        }
        .footer {
            clear: both;
            margin-top: 80px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #10b981;
            color: white;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <div class="company-name">' . htmlspecialchars($prevente['nom_entreprise']) . '</div>
            <div>' . htmlspecialchars($prevente['adresse_entreprise']) . '</div>
            <div>SIRET: ' . htmlspecialchars($prevente['siret']) . '</div>
            <div>Email: ' . htmlspecialchars($prevente['email_pro']) . '</div>
        </div>
        <div class="invoice-info">
            <div class="invoice-title">FACTURE</div>
            <div style="font-size: 16px; margin-top: 10px;">' . htmlspecialchars($invoiceNumber) . '</div>
            <div style="margin-top: 10px;">Date: ' . $invoiceDate . '</div>
            <div style="margin-top: 5px;"><span class="badge">PRÉVENTE</span></div>
        </div>
    </div>

    <div class="buyer-info">
        <div class="buyer-title">Facturé à:</div>
        <div><strong>' . htmlspecialchars($client['nom'] . ' ' . $client['prenom']) . '</strong></div>
        <div>' . htmlspecialchars($client['adresse']) . '</div>
        <div>Tél: ' . htmlspecialchars($client['phone']) . '</div>
        <div>Email: ' . htmlspecialchars($client['email']) . '</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: center; width: 100px;">Quantité</th>
                <th style="text-align: right; width: 120px;">Prix unitaire</th>
                <th style="text-align: right; width: 120px;">Total HT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>' . htmlspecialchars($prevente['description']) . '</strong><br>
                    <em style="color: #6b7280;">' . htmlspecialchars($prevente['produit_desc']) . '</em><br>
                    <small style="color: #10b981;">Prix prévente (économie de ' . number_format($prevente['prix_normal'] - $unitPrice, 2, ',', ' ') . ' €)</small>
                </td>
                <td style="text-align: center;">' . $quantity . '</td>
                <td style="text-align: right;">' . number_format($unitPrice, 2, ',', ' ') . ' €</td>
                <td style="text-align: right;"><strong>' . number_format($totalHT, 2, ',', ' ') . ' €</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="totals">
        <div class="total-row">
            <span>Sous-total HT:</span>
            <span>' . number_format($totalHT, 2, ',', ' ') . ' €</span>
        </div>
        <div class="total-row">
            <span>TVA (20%):</span>
            <span>' . number_format($tva, 2, ',', ' ') . ' €</span>
        </div>
        <div class="total-row final">
            <span>Total TTC:</span>
            <span>' . number_format($totalTTC, 2, ',', ' ') . ' €</span>
        </div>
    </div>

    <div class="footer">
        <p><strong>Merci pour votre participation à cette prévente !</strong></p>
        <p style="margin-top: 10px;">Date limite de la prévente: ' . date('d/m/Y', strtotime($prevente['date_limite'])) . '</p>
        <p>Nombre minimum de participants: ' . $prevente['nombre_min'] . ' | Statut: ' . htmlspecialchars($prevente['statut']) . '</p>
        <p style="margin-top: 15px;">Conditions de paiement: Paiement à réception</p>
        <p>En cas de question, contactez-nous à ' . htmlspecialchars($prevente['email_pro']) . '</p>
    </div>
</body>
</html>';
    
    return $html;
}
/**
 * Déclenche le téléchargement automatique de la facture
 */
function downloadInvoice($filepath, $filename) {
    if (file_exists($filepath)) {
        // Définir les headers pour forcer le téléchargement
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filepath));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        
        // Vider le buffer de sortie
        ob_clean();
        flush();
        
        // Lire et envoyer le fichier
        readfile($filepath);
        exit;
    }
}
/**
 * Récupérer les factures d'un client avec les infos de prévente
 */
function getClientInvoices($idClient) {
    $pdo = connectDB();
    if (!$pdo) {
        return false;
    }
    
    $req = "SELECT f.*, pa.created_at as date_participation, pr.description as prevente_desc,
            pr.prix_prevente, p.prix as prix_normal
            FROM facture f
            JOIN participation pa ON f.id_facture = pa.id_facture
            JOIN prevente pr ON pa.id_prevente = pr.id_prevente
            JOIN produit p ON pr.id_produit = p.id_produit
            WHERE pa.id_client = ?
            ORDER BY f.date_facture DESC";
    
    $stmt = $pdo->prepare($req);
    $stmt->execute([$idClient]);
    $factures = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    deconnectDB($pdo);
    return $factures;
}




?>


