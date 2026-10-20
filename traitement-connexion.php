<?php
session_start();

require_once('connexion.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email !== '' && $password !== '') {

        $request = $db->prepare("SELECT * FROM profil WHERE email = :email");

        $request->execute([
            ':email' => $email
        ]);

        $profil = $request->fetch();

        if ($profil && password_verify($password, $profil['password'])) {

            session_regenerate_id(true);

            $_SESSION['profil_id'] = $profil['id'];

            header('Location: index.php');
            exit();

        } else {
            echo "Email ou mot de passe incorrect !";
        }

    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>