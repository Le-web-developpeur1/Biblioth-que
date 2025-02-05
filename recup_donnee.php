<?php
require 'connect.php';

// Récupérer les données du formulaire
$titre = $_POST['title'];
$auteur = $_POST['author'];
$genre = $_POST['genre'];
$annee = $_POST['year'];

// Créer une instance de la classe Connect
$db = new Connect();

// Insérer les données dans la base de données
if ($db->insertBook($titre, $auteur, $genre, $annee)) {
    header('Location: index.php?status=success');
} else {
    header('Location: index.php?status=error');
}
?>
