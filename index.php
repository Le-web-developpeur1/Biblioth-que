<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Bibliothéque de livres</title>
</head>
<body>
    <header>
        <h1>Gestion de Bibliothèque</h1>
    </header>

    <?php 
    if (isset($_GET['status'])) { 
        if ($_GET['status'] == 'success') { 
        } elseif ($_GET['status'] == 'error') {
            echo "<p style='color: red;'>Erreur lors de l'opération. Veuillez réessayer.</p>"; 
        } 
    } 
    ?>

    <h2>Ajouter un livre</h2>
    <form id="myForm" action="recup_donnee.php" method="post">
        <div class="form-group">
            <label for="title">Titre :</label>
            <input type="text" id="titre" name="title" placeholder="Titre du livre" required>
        </div>
        <div class="form-group">
            <label for="author">Auteur :</label>
            <input type="text" id="auteur" name="author" placeholder="Auteur du livre" required>
        </div>
        <div class="form-group">
            <label for="genre">Genre :</label>
            <input type="text" id="genre" placeholder="Genre du livre" name="genre" required>
        </div>
        <div class="form-group">
            <label for="year">Année :</label>
            <input type="number" id="an" name="year" placeholder="Anée de publication" required>
        </div>
        <button type="submit" id="submitBtn">Ajouter</button>
    </form>

    <h2>Liste des livres</h2>
    <table id="dataTable">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Genre</th>
                <th>Année</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Connexion à la base de données
            require 'connect.php';
            $db = new Connect();

            // Récupérer les livres de la base de données
            $sql = "SELECT id, titre, auteur, genre, annee FROM livres";
            $stmt = $db->query($sql);

            // Afficher les livres dans le tableau
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["titre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["auteur"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["genre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["annee"]) . "</td>";
                    echo "<td>
                            <form style='display: inline;' method='POST' action='delete_book.php'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <button type='submit' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce livre ?\")'>Supprimer</button>
                            </form>
                            <form style='display: inline;' method='GET' action='edit_book.php'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <button type='submit'>Modifier</button>
                            </form>
                          </td>";
                }
            } else {
                echo "<tr><td colspan='5'>Aucun livre trouvé.</td></tr>";
            }
            ?>
        </tbody>
    </table>    
</body>
</html>
