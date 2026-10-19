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


    
    header('Location: connexion-profil.php');
    exit();


?>