<?php
require_once('connexion.php');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

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


        <div class="chat-container">
            <?php foreach ($messages as $message): ?>
                <div class="message-box">

                    <img
                        src="uploads/<?= htmlspecialchars($message['photoDeProfil']) ?>"
                        alt="Photo de profil"
                        class="photoDeProfil">

                    <div class="message-content">

                        <div class="pseudoEtHeure">
                            <span class="pseudo">
                                <?= htmlspecialchars($message['pseudo']) ?>
                            </span>

                            <span class="date-message">
                                <?= date('H:i', strtotime($message['datehour'])) ?>
                            </span>
                        </div>

                        <span class="texte-message">
                            <!-- Modification ici : nl2br entoure le htmlspecialchars -->
                            <?= nl2br(htmlspecialchars($message['message'])) ?>
                        </span>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <form action="./envoyer-message.php" method="POST" class="chat-form">
        <input type="hidden" name="profil_id" value="<?= (int) $id ?>">
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
    });
</script>

</body>

</html>