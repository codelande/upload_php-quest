<?php
// Je vérifie si le formulaire est soumis comme d'habitude
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Securité en php
    $maxFileSize = 1000000;

    define('MAX_FILE_SIZE', $maxFileSize);
    // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés (attention ce dossier doit être accessible en écriture)
    $uploadDir = 'public/uploads/';
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $uploadFile = $uploadDir . uniqid() . "." . $extension;
    // Les extensions autorisées
    $authorizedExtensions = ['jpg', 'gif', 'png', 'webp'];
    // Le poids max géré par PHP par défaut est de 2M
    // Je sécurise et effectue mes tests
    /****** Si l'extension est autorisée *************/
    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou gif ou webp ou Png !';
    }
    /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }
    /****** Si je n'ai pas d"erreur alors j'upload *************/
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    }
    if (empty($errors)) {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">

        <label for="imageUpload">Upload an profile image</label>

        <input type="file" name="avatar" id="imageUpload" />

        <button name="send">Send</button>

    </form>
    <?php if (empty($errors) && isset($uploadFile)) { ?>
        <img src=<?= $uploadFile ?>>
        <?php } ?>

</body>

</html>