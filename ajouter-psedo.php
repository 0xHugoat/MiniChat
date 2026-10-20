<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniChat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<form action="traitement.php" method="post">
    <label for="nom">Votre Nom</label>
    <input type="text" id="nom" name="nom" placeholder="Entrez votre nom...">
    <br />
    <label for="prenom">Votre prenom</label>
    <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prenom...">
    <br />
    <label for="pseudo">Votre pseudo</label>
    <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo...">
    <br />
    <label for="lastname">photo de profil</label>
    <input type="file" id="photoDeProfil" name="photoDeProfil" >
    <br />
    <label for="mail">Votre e-mail</label>
    <input type="email" id="email" name="email" placeholder="Entrez votre mail...">
    <br />
    <label for="password">Votre mot de passe</label>
    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe...">
    <br />
    <input type="submit" value="Incription" name="create_profil">
    
</form>


</body>
</html>


<?php

require_once('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $pseudo = trim($_POST['pseudo'] ?? '');
    $photoDeProfil = trim($_POST['photoDeProfil'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    if ($nom === '' || $prenom === '' || $pseudo === '' || $photoDeProfil === '' || $email === '' || $password === '') {
        exit("Veuillez remplir les champs obligatoires.");
    }

    $sql = "INSERT INTO profil
            (nom, prenom, pseudo, photoDeProfil, email, password)
            VALUES
            (:nom, :prenom, :pseudo, :photoDeProfil, :email, :password)";

    $stmt = $db->prepare($sql);

    $resultat = $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':pseudo' => $pseudo,
        ':photoDeProfil' => $photoDeProfil,
        ':email' => $email,
        ':password' => $password

    ]);

}


    
    if (isset($_POST['create_profil'])) {

    // Ton code pour enregistrer le profil

    header('Location: connexion-profil.php');
    exit();
}


?>

