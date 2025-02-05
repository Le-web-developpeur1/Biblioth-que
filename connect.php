<?php
class Connect extends PDO 
{
    const HOST = 'localhost';
    const DB = 'bibliotheque';
    const USER = 'root';
    const PSW = '';
    public function __construct()
    {
        try {
            parent::__construct("mysql:dbname=" . self::DB . ";host=" . self::HOST, self::USER, self::PSW);
        } catch (PDOException $e) {
            echo $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
    }

    public function insertBook($titre, $auteur, $genre, $annee)
    {
        $sql = "INSERT INTO livres (titre, auteur, genre, annee) VALUES (:titre, :auteur, :genre, :annee)";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':annee', $annee);
        return $stmt->execute();
    }
}
?>
