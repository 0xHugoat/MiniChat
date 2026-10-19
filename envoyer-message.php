<?php
require_once('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $envoieMessage = trim($_POST['envoieMessage'] ?? '');
    $profil_id = filter_input(INPUT_POST, 'profil_id', FILTER_VALIDATE_INT);

    if ($envoieMessage === '' || !$profil_id || $profil_id <= 0) {
        exit("Veuillez remplir les champs obligatoires.");
    }

    // Vérifier que le profil existe
    $request = $db->prepare("SELECT id FROM profil WHERE id = :id");
    $request->execute([':id' => $profil_id]);

    if (!$request->fetch()) {
        exit("Profil introuvable.");
    }

    // Enregistrer le message
    $sql = "INSERT INTO message
            (profil_id, message)
            VALUES
            (:profil_id, :message)";

    $stmt = $db->prepare($sql);

    $resultat = $stmt->execute([
        ':profil_id' => $profil_id,
        ':message' => $envoieMessage
    ]);

    // Retourner sur le MiniChat
    header('Location: index.php?id=' . $profil_id);
    exit;
}