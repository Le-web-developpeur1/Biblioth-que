<?php
require 'connect.php';
$db = new Connect();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'entrée en transformant en entier

    // Récupérer les informations du livre
    $sql = "SELECT * FROM livres WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        // Rediriger si le livre n'existe pas
        header("Location: index.php?status=error");
        exit;
    }
} else {
    // Rediriger si aucun ID n'est fourni
    header("Location: index.php?status=error");
    exit;
}

// Mettre à jour les informations si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $genre = htmlspecialchars($_POST['genre']);
    $year = intval($_POST['year']);
    $id = intval($_POST['id']);

    // Mettre à jour les données en base
    $sql = "UPDATE livres SET titre = :title, auteur = :author, genre = :genre, annee = :year WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':author', $author, PDO::PARAM_STR);
    $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirection après la mise à jour
        header("Location: index.php?status=success");
        exit;
    } else {
        header("Location: edit_book.php?id=$id&status=error");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Modifier un livre</title>
</head>
<body>
    <header>
        <h1>Modifier le livre</h1>
    </header>

    <?php 
    if (isset($_GET['status']) && $_GET['status'] == 'error') {
        echo "<p style='color: red;'>Erreur lors de la modification du livre. Veuillez réessayer.</p>";
    }
    ?>

    <form action="edit_book.php?id=<?= $book['id'] ?>" method="post">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">
        <div class="form-group">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['titre']) ?>" required>
        </div>
        <div class="form-group">
            <label for="author">Auteur :</label>
            <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['auteur']) ?>" required>
        </div>
        <div class="form-group">
            <label for="genre">Genre :</label>
            <input type="text" id="genre" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" required>
        </div>
        <div class="form-group">
            <label for="year">Année :</label>
            <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['annee']) ?>" required>
        </div>
        <button type="submit">Enregistrer</button>
    </form>
    <a href="index.php">Retour à la liste</a>
</body>
</html>
