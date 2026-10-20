<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="traitement-connexion.php" method="post">
        <label for="email">Votre e-mail</label>
        <input type="email" name="email" id="email" placeholder="Exemple@exemple.com" require>
        <label for="password">Votre mot de passe</label>
        <input type="password" name="password" id="password" require>
        <button type="submit" name="connexion">Se connecter</button>
    </form>
</body>
</html>