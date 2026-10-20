<?php
require_once('connexion.php');


session_start();

require_once('connexion.php');

if (!isset($_SESSION['profil_id'])) {
    header('Location: connexion-profil.php');
    exit();
}

$id = $_SESSION['profil_id'];

$sql = "SELECT message.*, profil.*
        FROM message
        INNER JOIN profil
        ON message.profil_id = profil.id
        ORDER BY message.datehour ASC, message.id ASC";

$stmt = $db->query($sql);
$messages = $stmt->fetchAll();

$sql = "SELECT * FROM profil";
$stmt = $db->query($sql);
$profils = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniChat</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="minichat">
        <div class="profil-container">
            <?php foreach ($profils as $profil): ?>
                <div class="message-box">
                    <img
                        src="uploads/<?= htmlspecialchars($profil['photoDeProfil']) ?>"
                        alt="Photo de profil"
                        class="photoDeProfil">

                    <span class="pseudo"><?= htmlspecialchars($profil['pseudo']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>


        <div class="chat-container" id="chat-container">

            
        </div>
    </div>
    <form action="./envoyer-message.php" method="POST" class="chat-form">
        <input
            type="text"
            name="envoieMessage"
            placeholder="Envoyer un message..."
            required>
        <button type="submit" <?= !$id ? 'disabled' : '' ?>>Envoyer</button>
    </form>

    <script>
    window.addEventListener('load', function () {
        window.scrollTo(0, document.body.scrollHeight);
    
    const chat = document.getElementById('chat-container');

async function recupererMessages() {
    try {
        const response = await fetch('recuperer-messages.php');

        if (!response.ok) {
            return;
        }

        const messages = await response.json();

        const estEnBas =
            window.innerHeight + window.scrollY >=
            document.documentElement.scrollHeight - 100;

        chat.innerHTML = '';

        messages.forEach(message => {
            const div = document.createElement('div');
            div.className = 'message-box';

            const photo = document.createElement('img');
            photo.className = 'photoDeProfil';
            photo.src = 'uploads/' + encodeURIComponent(message.photoDeProfil);

            const contenu = document.createElement('div');
            contenu.className = 'message-content';

            const entete = document.createElement('div');
            entete.className = 'pseudoEtHeure';

            const pseudo = document.createElement('span');
            pseudo.className = 'pseudo';
            pseudo.textContent = message.pseudo;

            const heure = document.createElement('span');
            heure.className = 'date-message';
            heure.textContent = message.datehour.substring(11, 16);

            const texte = document.createElement('span');
            texte.className = 'texte-message';
            texte.textContent = message.message;
            texte.style.whiteSpace = 'pre-wrap';

            entete.append(pseudo, heure);
            contenu.append(entete, texte);
            div.append(photo, contenu);
            chat.appendChild(div);
        });

        if (estEnBas) {
            window.scrollTo(0, document.body.scrollHeight);
        }

    } catch (error) {
        console.error('Erreur AJAX :', error);
    }
}

// Charger les messages immédiatement
recupererMessages();

// Vérifier les nouveaux messages toutes les 2 secondes
setInterval(recupererMessages, 2000);
    });
</script>

</body>

</html>